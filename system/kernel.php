<?php
/**
 * @author Roy
 */

function main(){
    $class = ucfirst( $_GET[ 'a' ] ? $_GET[ 'a' ] : 'main'  ) . 'Action';
    $file = ROOT_DIR . '/action/' . $_GET[ 'm' ] . '/' . $class . '.php';

    if( file_exists( $file ) ){
        require $file;
        $action = new $class;
        try{
            $action->init();
            $action->filter();
            $action->execute();
        }catch( Exception $e ){
            $action->error( $e->getMessage() , $e->getCode() );
        }
    }else
        require ROOT_DIR . '/public/404.html';
}

function c( $key = 'all' , $filename = 'config' ){
    static $config = array();

    if( empty( $config[ $filename ] ) ){
        $file = ROOT_DIR . '/config/' . $filename . '.php';
        if( file_exists( $file ) ) $config[ $filename ] = require $file;
    }

    if( $key === 'all' ) return $config[ $filename ];

    if( isset( $config[ $filename ][ $key ] ) )
        return $config[ $filename ][ $key ];
}

function t( $text , $params = array( ) , $package = 'core' ){
    static $i18n = array( );

    if( empty( $i18n[ $package ] ) ){
        $file = ROOT_DIR . '/i18n/' . $package . '.php';

        if( file_exists( $file ) )
            $i18n[ $package ] = require $file;
        else
            return $text;
    }

    if( empty( $i18n[ $package ][ $text ] ) ) return $text;

    $sentence = $i18n[ $package ][ $text ];

    if( $params ){
        $keys = $replaces = array( );

        foreach( $params as $key => $value ){
            $key = '{' . $key . '}';
            $keys[] = $key;
            $replaces[ $key ] = $value;
        }

        $sentence = str_replace( $keys , $replaces , $sentence );
    }

    return $sentence;
}

function __autoload( $className ){
    $type = substr( $className , -4 );
    $dir = $type === 'Data' ? '/data/' : '/model/';
    $file = ROOT_DIR . $dir . $className . '.php';

    if( file_exists( $file ) ) require $file;
}

abstract class Action{

    protected $layout = 'main';

    protected $user = null;

    public $method = 'get';

    public function __construct(){
        session_start();
        setcookie( 'flash' , '' );
        if( $_SERVER['REQUEST_METHOD'] === 'POST' ) 
            $this->method = 'post';

        if( isset( $_SESSION['user_id'] ) && $_SESSION['user_id'] > 0 )
            $this->user = User::load( $_SESSION['user_id'] );
    }

    public function init(){}

    public function filter(){}

    public function error( $message , $code ){
        var_dump( $message );
        //require ROOT_DIR . '/public/error.html';
    }

    abstract function execute();

    /**
     * @param string $key
     * @param int $type self::PARAM_TYPE_INT or self::PARAM_TYPE_STRING
     * @param mixed $default
     * @return mixed param value
     */
    protected function get( $key , $default = null ){
        if( empty( $_GET[ $key ] ) ){
            if( $default === null )
                throw new Exception( t( 'param missing' , array( 'param' => $key ) ) );

            return $default;
        }

        return trim( $_GET[ $key ] );
    }

    /**
     * @param string $key
     * @param int $type self::PARAM_TYPE_INT or self::PARAM_TYPE_STRING
     * @param mixed $default
     * @return mixed param value
     */
    protected function post( $key , $default = null ){
        if( empty( $_POST[ $key ] ) ){
            if( $default === null )
                throw new Exception( t( 'param missing' , array( 'param' => $key ) ) );

            return $default;
        }

        return trim( $_POST[ $key ] );
    }

    protected function tpl( $path ){
        return ROOT_DIR . '/template/' . $path . '.php';
    }

    protected function render( $contentTemplatePath , $data = array() ){
        extract( $data );
        require $this->layout ? $this->tpl( 'layout/' . $this->layout ) : $this->tpl( $contentTemplatePath );
    }

    protected function redirect( $url ){
        header( 'Location: ' . $url );
        exit;
    }

    protected function cookie( $key ){
        return empty( $_COOKIE[ $key ] ) ? '' : $_COOKIE[ $key ];
    }

    protected function createUrl( $m , $a = null , $params = array() ){
        if( strncmp( $m , 'http://' , 7 ) === 0 )
            return $m;

        $query = '';
        foreach( $params as $key => $value ) 
            $query .= '&' . $key . '=' . $value;

        if( $a ) return '/index.php?m=' . $m . '&a=' . $a . $query;

        return '/' . $m;
    }
}

/**
 * @author Roy
 */
class Data{

    /**
     * singleton object
     * @var array
     */
    private static $pool;

    /**
     * mysql database connection
     */
    protected $pdo;

    /**
     * redis database connection 
     * @var Redis
     */
    protected $cache;

    /**
     * data tableName used as table name or cache key prefix
     * @var string
     */
    protected $tableName;

    protected $hasMany = array();

    protected $hasOne = array();

    protected $belongsTO = array();


    /**
     * get single object of a data class
     * @param string $className
     * @return Model 
     */
    public static function getInstance( $name ){
        if( empty( self::$pool[ $name ] ) ){
            $class = $name . 'Data';
            self::$pool[ $name ] = new $class;
        }

        return self::$pool[ $name ];
    }

    /**
     * get mysql connection
     * @return mysql db connection
     */
    protected function initPdo(){
        if( empty( $this->pdo ) ){
            $config = c( 'db' );
            $this->pdo = new PDO( $config[ 'dsn' ] , $config[ 'username' ] , $config[ 'password' ] );
            $this->tableName = $config[ 'tablePrefix' ] . $this->tableName;
        }

        return $this->pdo;
    }

    protected function tableName( $name ){
        $config = c( 'db' );
        return $config['tablePrefix'] . $name;
    }

    /**
     * get cache connection
     * @return Reids
     */
    protected function initCache(){
        if( empty( $this->cache ) ){
            $this->cache = new Redis;
            $config = c( 'cache' );

            if( !$this->cache->pconnect( $config[ 'host' ] , $config[ 'port' ] ) )
                throw new KernelException( t( 'cache disconnected' ) , KernelException::CACHE_DISCONNECTED );
        }

        return $this->cache;
    }

    protected function cacheKey( $uniqueId ){
        return $this->tableName . '-' . $uniqueId;
    }

    /**
     * insert data
     * @param array $data
     * @return int 
     */
    public function insert( $data ){
        $columns = $values = array( );

        foreach( $data as $column => $value ){
            $columns[] = $column;
            $values[] = $value;
        }

        $this->initPdo()->exec( 'insert into `' . $this->tableName . '` (`' . implode( '`,`' , $columns ) . '`) values ("' . implode( '","' , $values ) . '")' );
        return $this->pdo->lastInsertId();
    }

    /**
     * update data 
     * @param array $data
     * @param string $where
     */
    public function update( $data , $where ){
        $tmp = '';

        foreach( $data as $column => $value ){
            $tmp .= '`' . $column . '`="' . $value . '",';
        }

        return $this->initPdo()->exec( 'update `' . $this->tableName . '` set ' . substr( $tmp , 0 , -1 ) . ' where ' . $where );
    }

    public function delete( $where , $limit = '1' ){
        return $this->initPdo()->exec( 'delete from `' . $this->tableName . '` where ' . $where . ' limit ' . $limit );
    }

    /**
     * get data from sql db
     * @return array
     */
    public function readOne( $where ){
        $result = $this->initPdo()->query( 'select * from `' . $this->tableName . '` where ' . $where . ' limit 0,1' );
        if( $result ) return $result->fetch( PDO::FETCH_ASSOC );
    }

    /**
     * find multi rows from sql db
     * @return array
     */
    public function read( $where , $order = '' , $limit = '' ){
        return $this->initPdo()->query( 'select * from `' . $this->tableName . '` where ' . $where . ' ' . $order . ' ' . $limit )->fetchAll( PDO::FETCH_ASSOC );
    }

    public function exec( $sql ){
        return $this->initPdo()->query( $sql )->fetchAll( PDO::FETCH_ASSOC );
    }

    public function count( $where = '1=1' ){
        $row = $this->initPdo()->query( 'select count(*) c from `' . $this->tableName . '` where ' . $where )->fetch( PDO::FETCH_ASSOC );
        return $row['c'];
    }

    public function isExist( $column , $value ){
        return $this->count( "`{$column}`='{$value}'" );
    }
}
<?php
/**
 * @author Roy
 */

function main(){
    $action = router();
    try{
        $action->init();
        $action->filter();
        $action->execute();
    }catch( Exception $e ){
        $action->error( $e->getMessage() );
    }
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

function t( $text , $params = array( ) , $package = 'main' ){
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

function router(){
    $url = $_SERVER['REQUEST_URI'];

    if( empty( $_GET['p'] ) ){
        $url = preg_replace( '/^\/index.php/' , '' , $url );
        $url = parse_url( $url );
        $url = pathinfo( $url['path'] );

        if( empty( $url['dirname'] ) || $url['dirname']  === '/' )
            $path = '/';
        else
            $path = $url['dirname'] . '/';

        $class = empty( $url['filename'] ) ? 'Main' : ucfirst( $url['filename'] );
        $format = empty( $url['extension'] ) ? 'html' : $url['extension'];
    }else{
        $path = $_GET['p'];
        $class = empty( $_GET['a'] ) ? 'Main' : ucfirst( $_GET['a'] );
        $format = empty( $_GET['f'] ) ? 'html' : $_GET['f'];
    }


    $class .= 'Action';
    $file = ROOT_DIR . '/action' . $path . $class . '.php';

    if( file_exists( $file ) )
        require_once $file;
    else
        require ROOT_DIR . '/public/404.html';

    return new $class( $path , $class , $format );
}

function __autoload( $className ){
    $type = substr( $className , -4 );
    $dir = $type === 'Data' ? '/data/' : '/model/';
    $file = ROOT_DIR . $dir . $className . '.php';

    if( file_exists( $file ) ) require_once $file;
}

abstract class Action{

    protected $layout = 'main';

    protected $user;

    protected $path;

    protected $name;

    protected $format;

    protected $method;
    
    protected $url;
    
    protected $moduleList;
    
    protected $role;
    
    public function __construct( $path , $name , $format ){
        session_start();
        setcookie( 'flash' , '' );
        date_default_timezone_set( c('timezone') );
        $this->method = strtolower( $_SERVER['REQUEST_METHOD'] );
        $this->url = $_SERVER['REQUEST_URI'];
        $this->path = $path;
        $this->name = $name;
        $this->format = $format;
        $this->hideScriptName = c( 'hideScriptName' );
        
        if (isset($_SESSION['user_id']) && $_SESSION['user_id'] > 0) {
          $this->user = User::load($_SESSION['user_id']);
          if ($this->user->data['status'] == 1) { 
            $this->role = Role::load($this->user->ez_role_id);
            $operationList = $this->role->getOperationList();
            $subList = array();
            $ultimateRoleList = array();
            for ($index = 0; $index < count($operationList); $index++) {
              $operation = $operationList[$index];
              if ($operation['parent_id'] == 0 && $index != 0) {
                array_push($ultimateRoleList, $subList);
                $subList = array();
                array_push($subList, $operation);
              } else {
                array_push($subList, $operation);
              }
            }
            array_push($ultimateRoleList, $subList);
            $this->moduleList = $ultimateRoleList;
          }
        }
    }

    public function init(){}

    public function filter(){}

    public function error( $message ){
        require ROOT_DIR . '/template/error.php';
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
        $value = $_POST[$key];
        
        return is_array($value) ? $value : trim($value);
    }

    protected function tpl( $path ){
        if( $path[0] != '/' ) $path = $this->path . $path;
        return ROOT_DIR . '/template' . $path . '.php';
    }

    protected function render( $contentTemplatePath , $data = array() ){
        extract( $data );
        require $this->layout ? $this->tpl( '/layout/' . $this->layout ) : $this->tpl( $contentTemplatePath );
    }

    protected function redirect(  $route , $params = array() ){
        header( 'Location: ' . $this->url( $route , $params ) );
        exit;
    }

    protected function cookie( $key ){
        return empty( $_COOKIE[ $key ] ) ? '' : $_COOKIE[ $key ];
    }

    protected function url( $route , $params = array() ){
        if( strncmp( $route , 'http://' , 7 ) === 0 ) return $route;

        if( $params ){
            $query = '';
            foreach( $params as $key => $value )
                $query .= '&' . $key . '=' . $value;
            $query[0] = '?';
            $route .= $query;
        }

        if( $route[0] != '/' ) $route = $this->path . $route;
        if( $this->hideScriptName ) return $route;
        return '/index.php' . $route;
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
                throw new Exception( t( 'cache server disconnected' ) );
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

        foreach( $data as $column => $value )
            $tmp .= '`' . $column . '`="' . $value . '",';

        return $this->initPdo()->exec( 'update `' . $this->tableName . '` set ' . substr( $tmp , 0 , -1 ) . ' where ' . $where );
    }

    public function deleteOne( $where , $limit = '1' ){
        return $this->initPdo()->exec( 'delete from `' . $this->tableName . '` where ' . $where . ' limit ' . $limit );
    }

    public function delete( $where ){
        return $this->initPdo()->exec( 'delete from `' . $this->tableName . '` where ' . $where );
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
        if( $order ) $order = ' order by ' .$order;
        if( $limit ) $limit = ' limit ' . $limit;

        $result = $this->initPdo()
                ->query( 'select * from `' . $this->tableName . '` where ' . $where . $order . $limit );
        if( $result ) return $result->fetchAll( PDO::FETCH_ASSOC );
        return array();
    }

    public function exec( $sql ){
        $result = $this->initPdo()->query( $sql );
        if( $result ) return $result->fetchAll( PDO::FETCH_ASSOC );
        return array();
    }

    public function count( $where = '1=1' ){
        $row = $this->initPdo()->query( 'select count(*) c from `' . $this->tableName . '` where ' . $where )->fetch( PDO::FETCH_ASSOC );
        return $row['c'];
    }

    public function isExist( $column , $value ){
        return $this->count( "`{$column}`='{$value}'" );
    }
}
<?php
namespace core\db;

class PdoMysql {

    private static $pdo;

    public static function getPdo(){
        if( empty( self::$pdo ) ){
            $config = c( 'db' );
            self::$pdo = new PDO( $config[ 'dsn' ] , $config[ 'username' ] , $config[ 'password' ] );
        }

        return self::$pdo;       
    }
}

/**
 * @author Roy
 */
class Mysqlpdo {

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
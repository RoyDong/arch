<?php
namespace core;

/**
 * @author Roy
 */
class Model {

    /**
     * singleton object
     * @var array
     */
    private static $pool = array();

    /**
     * mysql database connection
     */
    protected $pdo;

    /**
     * get single object of a data class
     * @param string $className
     * @return Model 
     */
    public static function pdo( $dsn , $username , $password ){
        if( empty( Model::$pool[ $dsn ] ) )
            Model::$pool[ $dsn ] = new PDO( $dsn , $username , $password );

        return Model::$pool[ $dsn ];
    }

    private function __construct( $dsn , $username , $password ){
        $config = c( 'dev' , 'db' );
        $this->pdo = self::pdo( 
                $config['dsn'] , 
                $config['username'] , 
                $config['password'] );
    }

    public function findOneByPk($id){
        return $this->findOne( '`id`="'.$id.'"' );
    }

    /**
     * insert data
     * @param array $data
     * @return int 
     */
    public function insert( $table , $data ){
        $columns = $values = array();

        foreach( $data as $column => $value ){
            $columns[] = $column;
            $values[] = $value;
        }

        $this->pdo->exec( 'INSERT INTO `'.$table.'` (`'
                .implode( '`,`' , $columns ).'`) VALUES ("'
                .implode( '","' , $values ).'")' );

        return $this->pdo->lastInsertId();
    }

    /**
     * update data 
     * @param array $data
     * @param string $where
     */
    public function update( $table ,$data , $where ){
        $sql = '';

        foreach( $data as $column => $value )
            $sql .= '`'.$column.'`="'.$value.'",';

        return $this->pdo->exec( 'UPDATE `'.$table. '` SET '
                .substr( $sql , 0 , -1 ).' WHERE '.$where );
    }

    public function deleteOne( $table , $where , $limit = '1' ){
        return $this->pdo->exec( 'DELETE FROM `'.$table.'` WHERE '
                .$where.' LIMIT '.$limit );
    }

    public function delete( $table , $where ){
        return $this->pdo->exec( 'DELETE FROM `'.$table.'` WHERE '.$where );
    }

    /**
     * get data from sql db
     * @return array
     */
    public function findOne( $table , $where ){
        $result = $this->pdo->query( 'SELECT * FROM `'.$table.'` where '.$where.' LIMIT 0,1' );
        if( $result ) return $result->fetch( PDO::FETCH_ASSOC );
    }

    /**
     * find multi rows from sql db
     * @return array
     */
    public function find( $table , $where , $order = '' , $limit = '' ){
        if( $order ) $order = ' ORDER BY ' .$order;
        if( $limit ) $limit = ' LIMIT ' . $limit;

        $result = $this->pdo->query( 
                'SELECT * FROM `'.$table.'` WHERE '.$where.$order.$limit );

        if( $result ) return $result->fetchAll( PDO::FETCH_ASSOC );
        return array();
    }

    public function count( $where = '1=1' ){
        $result = $this->pdo->query( 'SELECT count(*) c FROM `'.$table.'` WHERE '.$where );

        if( $result ){
            $count = $result->fetch( pdo::fetch_assoc );
            return $count['c'];
        }

        return 0;
    }
}
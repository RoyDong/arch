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


    protected $table = '';

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

    public function __construct(){
        $config = c( ENV , 'db' );
        $this->pdo = Model::pdo( 
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
    public function insert( $data ){
        $columns = $values = array();

        foreach( $data as $column => $value ){
            $columns[] = $column;
            $values[] = $value;
        }

        $this->pdo->exec( 'INSERT INTO `'.$this->table.'` (`'
                .implode( '`,`' , $columns ).'`) VALUES ("'
                .implode( '","' , $values ).'")' );

        return $this->pdo->lastInsertId();
    }

    /**
     * update data 
     * @param array $data
     * @param string $where
     */
    public function update( $data , $where ){
        $sql = '';

        foreach( $data as $column => $value )
            $sql .= '`'.$column.'`="'.$value.'",';

        return $this->pdo->exec( 'UPDATE `'.$this->table. '` SET '
                .substr( $sql , 0 , -1 ).' WHERE '.$where );
    }

    public function deleteOne( $where , $limit = '1' ){
        return $this->pdo->exec( 'DELETE FROM `'.$this->table.'` WHERE '
                .$where.' LIMIT '.$limit );
    }

    public function delete( $where ){
        return $this->pdo->exec( 'DELETE FROM `'.$this->table.'` WHERE '.$where );
    }

    /**
     * get data from sql db
     * @return array
     */
    public function findOne( $where ){
        $result = $this->pdo->query( 'SELECT * FROM `'.$this->table.'` where '.$where.' LIMIT 0,1' );
        if( $result ) return $result->fetch( PDO::FETCH_ASSOC );
    }

    /**
     * find multi rows from sql db
     * @return array
     */
    public function find( $where , $order = '' , $limit = '' ){
        if( $order ) $order = ' ORDER BY ' .$order;
        if( $limit ) $limit = ' LIMIT ' . $limit;

        $result = $this->pdo->query( 
                'SELECT * FROM `'.$this->table.'` WHERE '.$where.$order.$limit );

        if( $result ) return $result->fetchAll( PDO::FETCH_ASSOC );
        return array();
    }

    public function count( $where = '1=1' ){
        $result = $this->pdo->query( 'SELECT count(*) c FROM `'.$this->table.'` WHERE '.$where );

        if( $result ){
            $count = $result->fetch( pdo::fetch_assoc );
            return $count['c'];
        }

        return 0;
    }
}
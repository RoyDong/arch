<?php
namespace model;

class User {

    private static $table = 'user';

    private static $pool = array();

    private $isNew = true;

    private $data;

    public static function instance( $data ){
        if( is_array( $data ) ){
            if( empty( $data['id'] ) ) return null;
            $id = $data['id'];
        }else{
            $id = $data;
            $data = self::findOneByPk( $id );
            if( empty($data) ) return null;
        }

        if( empty( self::$pool[$id] ) ){
            $m = new self( $data );
            $m->isNew = false;
            self::$pool[$id] = $m;
        }

        return self::$pool[$id];
    }

    public function __construct( $data = array() ){
        $this->data = $data;
    }

    public static function findOneByPk( $id ){
        $mysql = \core\db\Mysql::instance( $dsn , $username , $password );
    }
}
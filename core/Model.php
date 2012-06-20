<?php
namespace core;

class Model {

    private static $pool = array();

    protected $data;

    public static function instance( $name , $data ){
        if( is_array( $data ) ){
            if( empty( $data['id'] ) )
                throw new Exception( 'incomplete model data while initializing ' . $name );

            $id = $data['id'];
        }else{
            $id = $data;
            $data = Model::readOneByPk( $id );
            if( empty($data) ) return null;
        }

        if( empty( Model::$pool[$id] ) )
            Model::$pool[$id] = new $name( $data );

        return Model::$pool[$id];
    }

    public static function readOneByPk( $id ){

    }

    protected function __construct( $data ){
        $this->data = $data;
    }
}

<?php
namespace core;

/**
 * @author Roy
 */
abstract class Model {

    protected $table = '';

    protected $data = array();

    protected $isNew = true;

    protected $cache;

    public function __construct(){
        if( empty( $this->table ) )
            throw new \Exception( 'table is not specified');

        $this->init();
    }

    public function __get( $name ){
        if( isset($this->data[$name]) )
            return $this->data[$name];
        else
            return $this->{'get'.ucfirst( $name )}();
    }

    public function __set( $name , $value ){
        $this->{'set'.ucfirst( $name )}( $value );
    }

    public function getData(){
        return $this->data;
    }

    abstract protected function init();

    abstract public function load( $data );
}

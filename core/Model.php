<?php
namespace core;

/**
 * @author Roy
 */
abstract class Model {

    protected $table = '';

    protected $data = array();

    protected $isNew = false;

    public function __construct(){
        if( empty($this->table ) ) throw new Exception( 'table is not specified');
        $this->init();
    }

    function init();

    function load( $data );
}

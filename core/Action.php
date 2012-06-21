<?php
namespace core;

abstract class Action {

    protected $method;

    public function __construct( $method ){
        $this->method = $method;
    }

    public function init(){}

    public function end(){}

    protected function redirect(  $route , $params = array() ){
        header( 'Location: ' . Core::url( $route , $params ) );
        exit;
    }

    public function error( $message , $code = 0 ){

    }
}
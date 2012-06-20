<?php
namespace core;

abstract class Action {

    protected $action;

    public function __construct( $action ){
        $this->action = $action;
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
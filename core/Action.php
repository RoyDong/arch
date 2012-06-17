<?php
namespace core;

abstract class Action {

    public function init(){}

    public function end(){}

    protected function redirect(  $route , $params = array() ){
        header( 'Location: ' . Core::url( $route , $params ) );
        exit;
    }

    public function error( $message , $code = 0 ){

    }
}
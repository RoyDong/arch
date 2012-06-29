<?php
namespace core;

class Session {

    public function __construct(){
        session_start();
    }

    public function __get( $name ){
        if( isset($_SESSION[$name]) ) return $_SESSION[$name];
    }

    public function __set( $name , $value ){
        $_SESSION[$name] = $value;
    }

    public function add( $name , $value ){
        if( isset($_SESSION[$name]) ) return false;
        $_SESSION[$name] = $value;
        return true;
    }
}
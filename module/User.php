<?php
namespace module;

class User {

    protected $username;

    public static function signin( $username , $password ){
        $admin = c( 'admin' );
        if( $username === $admin['username'] && 
                $password === $admin['password'] ){
            \Arch::$session->user = $username;
            return new User( $username );
        }
    }

    public static function current(){
        $username = \Arch::$session->user;
        if( $username )
            return new User( $username );
    }

    protected function __construct( $username ){
        $this->username = $username;
    }
}
<?php
namespace lib;

class User {

    private static $pool = array();

    private $user;

    private $profile;

    public static function instance( $id ){
        if( empty( User::$pool[$id] ) )
            User::$pool[$id] = new User( $id , $key );

        return User::$pool[$id];
    }

    public static function signin( $email ){

    }

    private function __construct( $id ){

    }
}
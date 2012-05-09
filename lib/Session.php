<?php
/**
 * session class
 * @author Roy
 */

class Session
{
    private static $obj;

    public static function getInstance()
    {
        if( empty( self::$obj ) )
        {
            self::$obj = new self;
        }

        return self::$obj;
    }

    public function __construct()
    {
        session_start();
    }

    public function __get( $name )
    {
        if( isset( $_SESSION[ $name ] ) )
        {
            return $_SESSION[ $name ];
        }
    }

    public function __set( $name , $value )
    {
        $_SESSION[ $name ] = $value;
    }

    public function add( $name , $value )
    {
        if( isset( $_SESSION[ $name ] ) )
        {
            return false;
        }

        $_SESSION[ $name ] = $value;
    }

    public function delete( $name )
    {
        unset( $_SESSION[ $name ] );
    }
}

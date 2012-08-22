<?php

class Arch {

    public static $command;

    public static $session;

    public static $log;

    public static $message;

    private static $config = array();

    private static $helpers = array();

    public static function run(){
        Arch::$log = new \core\Log;
        Arch::$session = new \core\Session;
        Arch::$message = new \core\Message;
        Arch::$command = new \core\Command;
        Arch::$command->exec();
    }

    public static function help( $name ){
        if( isset( Arch::$helpers[$name] ) ) return;
        $file = ROOT_DIR.'/helper/'.$name.'.php';
        require $file;
        Arch::$helpers[$name] = true;
    }

    public static function autoload( $className ){
        $file = ROOT_DIR.'/'.str_replace( '\\' , '/' , $className ).'.php';
        if( file_exists( $file ) ) require $file;
    }

    public static function exception( Exception $e ){
        switch( $e->getMessage() ){
            case 'finish':
                return;

            default:
                if( Arch::$command->dataType === 'html' )
                    Arch::$command->action->error( $e );
                else{
                    header( 'HTTP/1.1 508 Arch Framework Error' );
                    echo $e->getMessage();
                }
        }
    }

    public static function shutdown(){
        $e = error_get_last();
    }

    public static function & config( $key = '*' , $filename = 'config' ){
        if( empty( Arch::$config[ $filename ] ) ){
            $file = ROOT_DIR.'/config/'.$filename.'.php';
            if( file_exists( $file ) ) 
                Arch::$config[ $filename ] = require $file;
        }

        if( $key === '*' ) return Arch::$config[ $filename ];

        if( isset( Arch::$config[ $filename ][ $key ] ) )
            return Arch::$config[ $filename ][ $key ];
    }
}

function t( $text , $params = array() , $package = 'main' ){
    static $i18n = array();

    if( empty( $i18n[$package] ) ){
        $file = ROOT_DIR.'/i18n/'.$package.'.php';

        if( file_exists( $file ) )
            $i18n[$package] = require $file;
        else
            return $text;
    }

    if( empty( $i18n[ $package ][ $text ] ) ) return $text;

    $sentence = $i18n[ $package ][ $text ];

    if( $params ){
        $keys = $replaces = array();

        foreach( $params as $key => $value ){
            $key = '{'.$key.'}';
            $keys[] = $key;
            $replaces[$key] = $value;
        }

        $sentence = str_replace( $keys , $replaces , $sentence );
    }

    return $sentence;
}

spl_autoload_register( 'Arch::autoload' );
set_exception_handler( 'Arch::exception' );
register_shutdown_function( 'Arch::shutdown' );
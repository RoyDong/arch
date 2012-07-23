<?php

class App {

    public static $user;

    public static $command;

    public static $session;

    public static $log;

    public static $action;

    public static $message;

    private static $config = array();

    public static function run(){
        App::$log = new \core\Log;
        App::$session = new \core\Session;
        App::$message = new \core\Message;
        App::$command = new \core\Command;
        App::$command->exec();
    }

    public static function url( $url , $params = array() ){
        if( strncmp( $url , 'http' , 4 ) === 0 ) return $url;

        if( is_array( $params ) ){
            $query = '';

            foreach( $params as $key => $value )
                $query .= '&' . $key . '=' . $value;

            $query[0] = '?';
            $url = $url . $query;
        }

        return '/' . $url;
    }

    public static function autoload( $className ){
        $file = ROOT_DIR.'/'.str_replace( '\\' , '/' , $className ).'.php';
        if( file_exists( $file ) ) require $file;
    }

    public static function shutdown(){
        $e = error_get_last();
    }

    public static function config( $key = '*' , $filename = 'config' ){
        if( empty( App::$config[ $filename ] ) ){
            $file = ROOT_DIR.'/config/'.$filename.'.php';
            if( file_exists( $file ) ) 
                App::$config[ $filename ] = require $file;
        }

        if( $key === '*' ) return App::$config[ $filename ];

        if( isset( App::$config[ $filename ][ $key ] ) )
            return App::$config[ $filename ][ $key ];
    }
}

spl_autoload_register( 'App::autoload' );
register_shutdown_function( 'App::shutdown' );

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
        $keys = $replaces = array( );

        foreach( $params as $key => $value ){
            $key = '{'.$key.'}';
            $keys[] = $key;
            $replaces[$key] = $value;
        }

        $sentence = str_replace( $keys , $replaces , $sentence );
    }

    return $sentence;
}

function dump( $var , $html = false ){
    if( $html ){
        echo '<pre>';
        print_r( $var );
    }else
        file_put_contents( ROOT_DIR.'/log/debug.log' , 
                var_export( $var , true ) . "\n\n" , FILE_APPEND );
}

function isEmail( $email ){
    return preg_match( '/^[\w\._\-]+@[\w\.\-_]*[\w\-_]\.[a-z]{2,4}$/i' , $email );
}
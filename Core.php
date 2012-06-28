<?php

function c( $key = 'all' , $filename = 'config' ){
    static $config = array();

    if( empty( $config[ $filename ] ) ){
        $file = ROOT_DIR . '/config/' . $filename . '.php';
        if( file_exists( $file ) ) $config[ $filename ] = require $file;
    }

    if( $key === 'all' ) return $config[ $filename ];

    if( isset( $config[ $filename ][ $key ] ) )
        return $config[ $filename ][ $key ];
}

function t( $text , $params = array() , $package = 'main' ){
    static $i18n = array( );

    if( empty( $i18n[ $package ] ) ){
        $file = ROOT_DIR . '/i18n/' . $package . '.php';

        if( file_exists( $file ) )
            $i18n[ $package ] = require $file;
        else
            return $text;
    }

    if( empty( $i18n[ $package ][ $text ] ) ) return $text;

    $sentence = $i18n[ $package ][ $text ];

    if( $params ){
        $keys = $replaces = array( );

        foreach( $params as $key => $value ){
            $key = '{' . $key . '}';
            $keys[] = $key;
            $replaces[ $key ] = $value;
        }

        $sentence = str_replace( $keys , $replaces , $sentence );
    }

    return $sentence;
}

function isEmail( $email ){
    return preg_match( '/^[\w\._\-]+@[\w\.\-_]+[\w\-_]\.[a-z]{2,4}$/i' , $email );
}

class App {

    private static $command;

    public static function run(){
        $command = new \core\Command;
        $command->exec();
        App::$command = $command;
    }

    public static function url( $url , $params = array() ){
        if( strncmp( $url , 'http://' , 7 ) === 0 ||
                strncmp( $url , 'https://' , 7 ) === 0 )
            return $url;

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
        $file = ROOT_DIR .'/'. str_replace( '\\' , '/' , $className ) . '.php';
        if( file_exists( $file ) ) require $file;
    }
}

spl_autoload_register( 'App::autoload' );
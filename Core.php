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

class Core {

    private static $command;

    public static function gogogo(){
        $command = new \core\Command( $_SERVER['REQUEST_URI'] );
        $command->exec();
        self::$command = $command;
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

        if( self::$command->hasScriptName )
            $url = 'index.php/' . $url;

        return '/' . $url;
    }

    public static function redirect( $url , $params ){
        header( 'Location: ' . self::url( $url , $params ) );
        exit;
    }

    public static function autoload( $className ){
        $file = ROOT_DIR .'/'. str_replace( '\\' , '/' , $className ) . '.php';
        if( file_exists( $file ) ) require $file;
    }
}

spl_autoload_register( 'Core::autoload' );
<?php
class Core {

    public static function gogogo(){
        $command = new \core\Command( $_SERVER['REQUEST_URI'] );
    }

    public static function autoload( $className ){
        $file = ROOT_DIR .'/'. str_replace( '\\' , '/' , $className ) . '.php';
        if( file_exists( $file ) ) require $file;
    }
}


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

spl_autoload_register( 'Core::autoload' );
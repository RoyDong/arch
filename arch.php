<?php

/**
 * Arch class, core class, all static methods, global callable.
 * 
 * @author Roy
 */
class Arch {

    /**
     * @var \core\Command
     */
    public static $command;

    /**
     * @var \core\Session
     */
    public static $session;

    /**
     * @var \core\Log
     */
    public static $log;

    /**
     * @var \core\Message
     */
    public static $message;

    private static $config = array();

    private static $helpers = array();

    /**
     * initialize core classes,
     * run the framework to process user requests
     * do not call this method manually
     */
    public static function run(){
        Arch::$log = new \core\Log;
        Arch::$session = new \core\Session;
        Arch::$message = new \core\Message;
        Arch::$command = new \core\Command;
        Arch::$command->exec();
    }

    /**
     * load helper
     * helper is a php file contains dozens of user defined functions
     * 
     * @param string $name helper name
     * @throws Exception when helper file not found
     */
    public static function help( $name ){
        if( isset( Arch::$helpers[$name] ) ) return;
        $file = ROOT_DIR.'/helper/'.$name.'.php';
        if( file_exists( $file ) ){
            require $file;
            Arch::$helpers[$name] = true;
        }else
            throw new Exception( 'can not find helper: '.$name );
    }

    /**
     * autoload function helps framework to load classes automatically.
     * by the help of namespace the loading process is very fast and
     * extremely simple.
     * do not call this method manually
     * 
     * @param string $className 
     */
    public static function autoload( $className ){
        $file = ROOT_DIR.'/'.str_replace( '\\' , '/' , $className ).'.php';
        if( file_exists( $file ) ) require $file;
    }

    /**
     * exception handler, handlers all exceptions threw in project
     * do not call this method manually
     * 
     * @param Exception $e
     */
    public static function exception( Exception $e ){
        switch( $e->getMessage() ){
            /**
             * finish exception means stop the process immediately
             * just like exit;
             */
            case 'finish':
                return;

            default:
                if( Arch::$command->dataType === 'default' )
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

    /**
     * get configuration
     * 
     * @param string $key
     * @param string $filename config file name
     * @return mixed value
     */
    public static function & config( $key = '*' , $filename = 'config' ){
        if( empty( Arch::$config[ $filename ] ) ){
            $file = ROOT_DIR.'/conf/'.$filename.'.php';
            if( file_exists( $file ) ) 
                Arch::$config[ $filename ] = require $file;
        }

        if( $key === '*' ) return Arch::$config[ $filename ];

        if( isset( Arch::$config[ $filename ][ $key ] ) )
            return Arch::$config[ $filename ][ $key ];
    }
}

/**
 * t means translate
 *
 * @staticvar array $i18n
 * @param string $text sentence to translate
 * @param string $params variable values
 * @param string $package language file name
 * @return string
 */
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
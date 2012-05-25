<?php
namespace core;

class Command {

    private static $params = array(
        '/' => '\/', // don't modify
        ':number' => '([0-9]+)',
        ':word' => '(\w+)',
    );

    private $path = '/';

    private $action = 'main';

    private $text;

    public $hasScriptName = false;

    public function __construct( $command ){
        if( strncmp( $command , '/index.php' , 9 ) === 0 ){
            $this->hasScriptName = true;
            $command = substr( $command , 10 );
        }

        $url = parse_url( $command );
        $command = $url['path'];
        $all = c( 'all' , 'command' );
        $keys = array_keys( self::$params );
        $replaces = self::$params;
        
        foreach( $all as $format => $config ){
            $format = '/^'. str_replace( $keys , $replaces , $format ) .'$/i';

            if( preg_match( $format , $command , $params ) ){
                $this->path = $config['path'];
                $this->action = $config['action'];
                array_shift( $params );
                foreach( $params as $n => $value ){
                    if( isset( $config[$n] ) )
                        $_GET[ $config[$n] ] = $value;
                }
            }
        }

        $this->text = $command;
        $this->all = $all;
    }

    public function exec(){
        $class = '\\action'. str_replace( '/' , '\\' , $this->path ).
                ucfirst( $this->action );
        $action = new $class;
        try{
            session_start();
            date_default_timezone_set( c('timezone') );
            $action->init();
            $action->exec();
            $action->end();
        }catch( Exception $e ){
            $action->error( $e->getMessage() , $e->getCode() );
        }
    }
}
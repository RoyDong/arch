<?php
namespace core;

class Log {

    protected $file;

    protected $fp;

    protected $on;

    public function __construct(){
        $config = c( 'log' );
        $this->on = isset( $config['on'] ) ? (bool)$config['on'] : false;

        if( $this->on ){
            $dir = isset( $config['dir'] ) ? $config['dir'] : ROOT_DIR.'/log';
            $this->file = $dir.'/'.ENVIRONMENT.'.log';
            $this->fp = fopen( $this->file , 'a' );
        }
    }

    public function add( $text , $environment = 'development' ){
        if( $this->on && ENVIRONMENT === $environment )
            fwrite( $this->fp , microtime( true ).' '.$text."\n" );
    }

    public function __destruct(){
        if( $this->on ) fclose( $this->fp );
    }
}
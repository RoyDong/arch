<?php
namespace core;

class Log {

    private $file;

    private $fp;

    public function __construct(){
        $this->file = ROOT_DIR.'/log/'.ENVIRONMENT.'.log';
        $this->fp = fopen( $this->file , 'a' );
    }

    public function add( $text , $environment = 'development' ){
        if( ENVIRONMENT === $environment )
            fwrite( $this->fp , microtime( true ).' '.$text."\n" );
    }

    public function __destruct(){
        fclose( $this->fp );
    }
}
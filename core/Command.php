<?php
namespace core;

class Command {

    private $text;

    public function __construct( $command ){
        if( strncmp( $command , '/index.php/' , 10 ) === 0 )
            $command = substr( $command , 11 );

        $url = parse_url( $command );
        $path = explode( '/' , $url['path'] );
        $node = c( 'all' , 'route' );
        
        foreach( $path as $nodeName ){

        }


        $this->text = $command;
    }

    private function checkPath(){

    }
}
<?php
namespace core;

class Command {

    private $text;

    public function __construct( $command ){
        if( strncmp( $command , '/index.php/' , 10 ) === 0 )
            $command = substr( $command , 11 );

        $this->text = $command;
        $url = parse_url( $command );
        $path = explode( '/' , $url['path'] );


        $u = new \lib\User;

        $u->setEmail();

    }
}
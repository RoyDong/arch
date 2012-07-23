<?php
namespace action;

class Index extends \core\Action {

    protected $user;

    public function __construct( $method ){
        $this->method = $method;
        $this->user = \module\User::current();
    }

    public function get(){
        if( $this->user )
            $this->render();
        else
            $this->render('welcome');
    }

    public function add(){
        echo json_encode( $_SERVER );
    }

    public function set(){
        throw new \Exception( 'error' );
    }
}
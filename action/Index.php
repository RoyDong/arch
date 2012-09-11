<?php
namespace action;

class Index extends \lib\Action {

    public function get(){
        if( $this->user )
            $this->render();
        else
            $this->render('index');
    }

    public function add(){
        echo json_encode( $_SERVER );
    }

    public function set(){
        throw new \Exception( 'error' );
    }
}

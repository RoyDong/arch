<?php
namespace action;

class Index extends \lib\Action {

    public function get(){
        $this->render('index');
    }

    public function add(){
        echo json_encode( $_SERVER );
    }

    public function set(){
        throw new \Exception( 'error' );
    }
}
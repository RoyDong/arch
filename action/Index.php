<?php
namespace action;

class Index extends \core\Action {

    public function get(){
        $this->render();
    }

    public function add(){
        echo json_encode( $_SERVER );
    }

    public function set(){
        throw new \Exception( 'error' );
    }
}
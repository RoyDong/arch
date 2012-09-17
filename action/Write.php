<?php
namespace action;

class Write extends \core\Action {

    public function get(){
        $this->render( 'write' );
    }

    public function set(){
        $this->render( 'index' );
    }
}
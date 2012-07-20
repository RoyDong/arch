<?php
namespace action\diary;

class Index extends \core\Action {

    protected $user;

    public function init(){
        $this->user = \module\User::current();
        if( !$this->user ){
            $this->render( '/user/welcome' );
        }
    }

    public function add(){

    }

    public function set(){

    }

    public function get(){

    }

    public function del(){

    }
}
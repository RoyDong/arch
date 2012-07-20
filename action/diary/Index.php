<?php
namespace action;

class Diary extends \core\Action {

    protected $user;

    public function init(){
        $this->user = \module\User::current();
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
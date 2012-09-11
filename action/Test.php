<?php
namespace action;

class Test extends \lib\Action {

    public function get(){
        //setcookie('i', '2', 0, '/' , '.diary.tool');
        $this->render();
    }

    public function add(){
        var_dump($_COOKIE);
    }

    public function set(){
    }
}
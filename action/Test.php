<?php
namespace action;

class Test extends \lib\Action {

    public function get(){

        $this->render();
    }

    public function add(){
        echo $_POST['text'];
    }

    public function set(){
    }
}
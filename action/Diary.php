<?php
namespace action;

class Diary extends \lib\Action {

    protected $user;

    public function add(){
        $this->user->writeDiary( $_POST['text'] , $_POST['weather'] );
    }

    public function set(){

    }

    public function get(){

    }

    public function del(){

    }
}
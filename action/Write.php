<?php
namespace action;

class Write extends \core\Action {

    protected $user;

    public function init(){
        $this->user = \module\User::current();
        if(empty($this->user)) $this->redirect('signin');
    }

    public function get(){
        $this->render();
    }

    public function add(){
        $result = $this->user->write( $_POST['title'] , $_POST['content'] );
        echo (int)$result;
    }
}
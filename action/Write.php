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
        echo json_encode($_POST);
    }
}
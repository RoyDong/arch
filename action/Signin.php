<?php
namespace action;

class Signin extends \core\Action {

    public function get(){
        $this->render();
    }

    public function set(){
        $user = \module\User::signin($_POST['username'], $_POST['password']);
        if($user) $this->redirect( 'write' );
        $this->render();
    }
}
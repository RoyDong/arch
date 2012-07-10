<?php
namespace action\user;

class Signin extends \core\Action {

    public function set(){
        \module\User::signin( $_POST['email'] , $_POST['password'] );
    }
}
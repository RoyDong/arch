<?php
namespace action\user;

class Signup extends \core\Action {

    public function init(){

    }
    
    public function add(){
        $email = trim( $_POST['email'] );

        if( isEmail( $email ) ){
            $user = new \model\User;
            if( $user->setEmail( $email ) )
                $user->password =  $_POST['password'];

            $user->save();
        }

        $this->redirect( $_SERVER['HTTP_REFERER'] );
    }
}
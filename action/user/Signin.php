<?php
namespace action\user;

class Signin extends \core\Action {

    public function init(){

    }

    public function set(){
        $email = trim( $_POST['email'] );

        if( isEmail( $email ) ){
            $user = new \model\User;
            if( $user->load( array( 'email' => $email ) ) ){
                $user->checkPassword( $_POST['password'] );
                var_dump( $user );
            }else
                echo 'user not found';
        }else
            echo 'email is not right';
    }
}
<?php
namespace action;

class Index extends \core\Action {

    public function get(){

        $this->renderJson();
    }

    public function set(){
        $email = trim( $_POST['email'] );

        if( isEmail( $email ) ){
            $user = new \model\User;
            if( $user->load( array( 'email' => $email ) ) ){
                $user->checkPassword( $_POST['password'] );
                var_dump($a , $user );
            }else
                echo 'user not found';
        }
    }

    public function add(){
        $email = trim( $_POST['email'] );

        if( isEmail( $email ) ){
            $user = new \model\User;
            if( $user->setEmail( $email ) )
                $user->password =  $_POST['password'];

            $user->save();
            echo 'done';
        }
    }
}
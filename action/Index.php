<?php
namespace action;

class Index extends \core\Action {

    public function init(){
        $this->addScript( 'http://code.jquery.com/jquery.min.js' );
    }

    public function get(){

        $this->render();
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
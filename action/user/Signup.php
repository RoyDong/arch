<?php
namespace action\user;

class Signup extends \core\Action {

    public function init(){

    }
    
    public function add(){
        $user = \module\User::signup( $_POST['email'] , $_POST['password'] );
        if( $user ){
            $this->render( null , '/index' );
        }else{
            echo 'done';
        }
    }
}
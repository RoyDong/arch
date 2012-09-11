<?php
namespace action;

class User extends \lib\Action {

    public function get(){

    }

    public function add(){
        $user = \module\User::signup( $_POST['email'] , $_POST['password'] );
        if( $user ){
            $this->redirect();
        }else{
            $this->render( 'index' );
        }
    }

    public function set(){
        $user = \module\User::signin( $_POST['email'] , $_POST['password'] );
        if( $user ){
            $this->redirect();
        }else
            $this->render( 'index' );
    }
}

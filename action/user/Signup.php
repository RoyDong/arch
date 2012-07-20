<?php
namespace action\user;

class Signup extends \core\Action {

    public function add(){
        $user = \module\User::signup( $_POST['email'] , $_POST['password'] );
        if( $user ){
            $this->redirect();
        }else{
            $this->render( 'welcome' );
        }
    }
}
<?php
namespace action\user;

class Signin extends \core\Action {

    public function set(){
        $user = \module\User::signin( $_POST['email'] , $_POST['password'] );
        if( $user ){
            $this->redirect();
        }else
            $this->render( 'welcome' );
    }
}
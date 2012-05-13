<?php

class SigninAction extends Action {

    public function execute(){
        if( $this->method === 'post' ){
            $user = User::loadByEmail( $this->post( 'email') );
            if( $user && $user->signin( $this->post( 'password' ) ) ){
                $this->redirect( $this->createUrl( 'weibo' , 'main' ) );
            }
            setcookie( 'flash' , 'wrong email or password' );
            $this->redirect( $this->createUrl( 'user' , 'signin' ) );
        }
        $this->layout = false;
        $this->render( 'user/signin' );
    }
}

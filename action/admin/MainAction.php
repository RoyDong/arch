<?php

class MainAction extends Action
{
  
    protected $layout = 'admin';

    public function filter()
    {
        $session = Session::getInstance();
        $user = $session->user;

        if( $user && $user['credential'] === 'admin' )
        {
            return;
        }

        $username = $this->post( 'username' );
        $password = $this->post( 'password' );
        $admin = c( 'admin' );

        if( $username !== $admin['username'] || $password != $admin['password'] )
        {
            throw new Exception( t( 'username or password error' ) , 41 );
        } 

        $session->user = array( 'userId' => 1 , 'username' => 'roy' , 'credential' => 'admin' );
    }
  
    public function execute()
    {
        $this->render( 'admin/main' );
    }

    public function error( $msg , $code )
    {
        $this->layout = null;
        $this->render( 'admin/login' , array( 'errorMsg' => $msg , 'errorCode' => $code ) );
    }
}

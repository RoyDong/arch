<?php

class AuthAction extends Action
{
  
    protected $layout = 'admin';
  
    public function execute()
    {
        $username = $this->post( 'username' );
        $password = $this->post( 'password' );
        $admin = c( 'admin' );

        if( $username !== $admin['username'] || $password != $admin['password'] )
        {
            throw new Exception( t( 'username or password error' ) , 41 );
        } 
        
        $this->render( 'admin/main' );
    }

    public function error( $msg , $code )
    {
        $this->layout = null;
        $this->render( 'admin/login' , array( 'errorMsg' => $msg , 'errorCode' => $code ) );
    }
}

<?php

class LoginAction extends Action
{

    protected $layout = null;
    
    
    public function execute()
    {
        $this->render( 'admin/login' );
    }
}

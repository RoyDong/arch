<?php

class LoginAction extends Action
{

    private $email;

    public function filter()
    {


    }

    public function execute()
    {
        $this->render( 'user/login' );
    }
}

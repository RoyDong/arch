<?php
namespace action;

class Index extends \core\Action {

    public function get(){

        var_dump(1);
    }

    public function add(){
        $email = trim( $_POST['email'] );

        if( isEmail( $email ) ){
            $user = new \model\User;
            if( $user->setEmail( $email ) )
                $user->password =  $_POST['password'];

            var_dump( $user->email , $user->password );
        }
    }
}

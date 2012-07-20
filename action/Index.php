<?php
namespace action;

class Index extends \core\Action {

    public function get(){
        if( \module\User::current() )
            $this->render();
        else
            $this->render( 'user/welcome' );
    }
}
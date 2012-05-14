<?php

/**
 * @authro Roy
 */


class NewAction extends Action{

    public function execute(){
        if( $this->method === 'post' ){
            $user = new User;
            if( !$user->setEmail( $this->post( 'email' ) ) )
                $this->redirect( $this->createUrl( 'user' , 'new' ) );

            $user->setUsername( $this->post( 'username' , '' ) );
            $user->save();
            $this->redirect( $this->createUrl( 'user' , 'edit' , array( 'id' => $user->id ) ) );
        }

        $this->render( 'user/new' );
    }
}
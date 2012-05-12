<?php

/**
 * @authro Roy
 */


class NewAction extends Action{

    public function execute(){
        $email = $this->post( 'email' , false );

        if( $email ){
            $user = new User;

            if( !$user->setEmail( $email ) )
                $this->redirect( $this->createUrl( 'user' , 'new' ) );

            $user->setUsername( $this->post( 'username' , '' ) );
            $user->save();
            $this->redirect( $this->createUrl( 'user' , 'edit' , array( 'id' => $user->id ) ) );
        }

        $this->layout = false;
        $this->render( 'user/new' );
    }
}

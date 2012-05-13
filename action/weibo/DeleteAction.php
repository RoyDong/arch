<?php
/**
 * @author Roy 
 */

class DeleteAction extends Action {

    public function filter(){
        if( empty( $this->user ) )
            $this->redirect( $this->createUrl( 'user' , 'signin' ) );
    }

    public function execute(){
        $this->user->deleteToken( $this->get( 'tokenId' ) );
        $this->redirect( $this->createUrl( 'weibo' , 'list' ) );
    }
}
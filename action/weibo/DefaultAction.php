<?php
/**
 * @author Roy 
 */

class DefaultAction extends Action {

    public function filter(){
        if( empty( $this->user ) )
            $this->redirect( $this->createUrl( 'user' , 'signin' ) );
    }

    public function execute(){
        $this->user->setOAuthTokenId( $this->get( 'tokenId' ) );
        $this->user->save();
        $this->redirect( $this->createUrl( 'weibo' , 'list' ) );
    }
}
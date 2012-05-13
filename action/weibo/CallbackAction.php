<?php
/**
 * @author Roy 
 */

class CallbackAction extends Action {

    public function filter(){
        if( empty( $this->user ) ) 
            $this->redirect( $this->createUrl( 'user' , 'signin' ) );
    }

    public function execute(){
        $oauth = WeiboApi::bindOauth( $this->user->id );
        $tokenId = $oauth->callback( $this->get( 'oauth_verifier' ) );
        if( !$this->user->oauth_token_id ){
            $this->user->setOAuthTokenId( $tokenId );
            $this->user->save();
        }
        $this->redirect( $this->createUrl( 'weibo' , 'list' ) );
    }
}
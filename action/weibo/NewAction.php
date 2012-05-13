<?php
/**
 * @author Roy 
 */

class NewAction extends Action {

    public function filter(){
        if( empty( $this->user ) )
            $this->redirect( $this->createUrl( 'user' , 'signin' ) );
    }

    public function execute(){
        $oauth = WeiboApi::bindOauth( $this->user->id );

        var_dump( $oauth->getAuthorizeURL() );
    }
}
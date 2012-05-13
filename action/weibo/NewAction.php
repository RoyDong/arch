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
        $this->layout = false;
        $oauth = WeiboApi::bindOauth( $this->user->id );
        $this->render( 'weibo/init' , array( 'url' => $oauth->getAuthorizeURL() ) );
        return;
    }
}
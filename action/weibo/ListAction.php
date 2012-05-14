<?php
/**
 * @author Roy 
 */

class ListAction extends Action {

    public function filter(){
        if( empty( $this->user ) ) 
            $this->redirect( $this->createUrl( 'user' , 'signin' ) );
    }

    public function execute(){
        $weiboList = $this->user->getWeiboList();

        if( empty( $weiboList ) ){
            $oauth = WeiboApi::bindOauth( $this->user->id );
            $this->render( 'weibo/init' , array( 'url' => $oauth->getAuthorizeURL() ) );
            return;
        }

        $this->render( 'weibo/list' , array( 'weiboList' => $weiboList ) );
    }
}
<?php
/**
 * @author Roy 
 */

class ListAction extends Action {

    public function execute(){
        $weiboList = $this->user->getWeiboList();

        if( empty( $weiboList ) ){
            $this->layout = false;
            $oauth = WeiboApi::bindOauth( $this->user->id );
            $this->render( 'weibo/init' , array( 'url' => $oauth->getAuthorizeURL() ) );
            return;
        }

        $this->layout = false;
        $this->render( 'weibo/list' , array( 'weiboList' => $weiboList ) );
    }
}
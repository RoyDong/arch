<?php
/**
 * @author Roy 
 */

class MainAction extends Action {

    public function filter(){
        if( empty( $this->user ) )
            $this->redirect( $this->createUrl( 'user' , 'signin' ) );
    }

    public function execute(){
        $api = $this->user->getDefaultWeiboApi();
        if( empty( $api ) ){
            $oauth = WeiboApi::bindOauth( $this->user->id );
            $this->render( 'weibo/init' , array( 'url' => $oauth->getAuthorizeURL() ) );
            return;
        }

        $page = $this->get( 'page' , 1 );

        $this->render( 
                'weibo/main' , 
                array(
                    'friendsTimeline' => $api->friendsTimeline( $page ),
                    'page' => $page,
                ));
    }
}

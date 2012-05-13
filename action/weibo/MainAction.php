<?php
/**
 * @author Roy 
 */

class MainAction extends Action {

    public function execute(){
        $api = $this->user->getDefaultWeiboApi();
        if( empty( $api ) ){
            $this->layout = false;
            $oauth = WeiboApi::bindOauth( $this->user->id );
            $this->render( 'weibo/init' , array( 'url' => $oauth->getAuthorizeURL() ) );
            return;
        }

        $page = $this->get( 'page' , 1 );

        $this->layout = false;
        $this->render( 
                'weibo/main' , 
                array( 
                    'friendsTimeline' => $api->friendsTimeline( $page ),
                    'page' => $page,
                ));
    }
}

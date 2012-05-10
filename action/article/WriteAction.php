<?php
/**
 * write article action
 * @author Roy
 */

class WriteAction extends Action
{

    public function filter()
    {
        $session = Session::getInstance();
        $user = $session->user;

        if( empty( $user ) )
        {
            throw new Exception( 'not login' , 13 );
        }
    }

    public function execute()
    {
        $article = new Article;
        $article->title = $this->post( 'title' );
        $article->content = $this->post( 'content' );
        $article->save();
        echo $article->id;
    }
}

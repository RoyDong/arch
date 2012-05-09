<?php
/**
 * show article
 * @author Roy
 */

class ShowAction extends Action
{

    public function execute()
    {
        $article = new Article( $this->get( 'id' ) );

        var_dump( $article->content , $article->title );
    }
}

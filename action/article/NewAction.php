<?php
/**
 * create a new article
 * @author Roy
 */

class NewAction extends Action
{

    protected $layout = null;

    public function execute()
    {

        $this->render( 'article/new' );
    }
}

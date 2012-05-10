<?php
 

class MainAction extends Action
{
  
    protected $layout = 'blog';
  
    public function execute() 
    {
        $articles = Article::find();
        $this->render( 'blog/main' , array( 'articles' => $articles ) );
    }
}
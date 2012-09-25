<?php
namespace action\article;

class Index extends \core\Action {

    public function get(){
        $article = new \model\Article;
        $this->render( 'index' , [ 
                'titles' => $article->getTitles(),
                'article' => $article->getLastOne()
            ] );
    }
}
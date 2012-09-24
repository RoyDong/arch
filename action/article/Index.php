<?php
namespace action\article;

class Index extends \core\Action {

    public function get(){
        $titles = \module\Article::getTitles();
        $this->render( 'index' , [ 'titles' => $titles ] );
    }
}
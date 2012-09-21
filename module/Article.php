<?php
namespace module;

class Article {

    public static function getTitles( $offset = 0 , $limit = 20 ){
        $article = new \model\Article;
        return $article->getTitles( $offset , $limit );
    }
}

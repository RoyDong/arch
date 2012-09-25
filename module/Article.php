<?php
namespace module;

class Article {

    public static function getTitles( $offset = 0 , $limit = 20 ){
        $offset = empty( $offset ) ? 0 : (int)$offset;
        $limit = empty( $limit ) ? 20 : (int)$limit;
        $article = new \model\Article;
        return $article->getTitles( $offset , $limit );
    }

    public static function getLastOne(){
        $article = new \model\Article;
    }
}

<?php
namespace action\article;

class Title extends \core\Action {

    public function get(){
        $titles = \module\Article::getTitles( $_GET['offset'] , $_GET['limit'] );
        echo json_encode( $titles );
    }
}
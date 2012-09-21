<?php
namespace model;

class Article extends \core\model\Mysql {
    
    protected $table = 'article';

    public function setTitle( $title ){
        $this->data['title'] = $title;
    }

    public function setContent( $text ){
        $this->data['content'] = $text;
    }

    public function getTitles( $offset = 0 , $limit = 20 ){
        return $this->find( '`dtime`=0' , '`ctime` DESC' , $offset.','.$limit , 
                '`id`,`title`,`ctime`,`utime`' );
    }
}
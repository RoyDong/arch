<?php
namespace model;

class Article extends \core\model\Mysql {
    
    protected $table = 'article';

    public function setTitle( $title ){
        $this->data['title'] = addslashes($title);
    }

    public function setContent( $text ){
        $this->data['content'] = addslashes($text);
    }

    public function getTitles( $offset = 0 , $limit = 20 ){
        $offset = empty( $offset ) ? 0 : (int)$offset;
        $limit = empty( $limit ) ? 20 : (int)$limit;

        return $this->find( '`dtime`=0' , '`ctime` DESC' , $offset.','.$limit , 
                '`id`,`title`,`ctime`,`utime`' );
    }

    public function getLastOne(){
        return $this->findOne( '`dtime`=0' , '`ctime` DESC' );
    }
}
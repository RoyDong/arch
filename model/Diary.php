<?php
namespace model;

class Diary extends \core\model\Mysql {

    protected $table = 'diary';

    private static $columns = array(
        'id' , 'text' , 'uid' , 'ctime' , 'utime'
    );

    public function getColumns(){
        return Diary::$columns;
    }

    public function setUid( $uid ){
        $this->data['uid'] = $uid;
    }

    public function setText( $text ){
        $this->data['text'] = $text;
    }

    public function getDiaries(){

    }

    public function getUserDiaries( $userId , $timeline = null , $limit = 30 ){
        if( $timeline === null ) $timeline = \Arch::$command->time;

        return $this->find(
                '`uid`="'.$userId.'" AND `ctime`<="'.$timeline.'"' ,
                '`ctime` DESC' , $limit );
    }
}
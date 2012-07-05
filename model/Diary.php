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
}
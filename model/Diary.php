<?php
namespace model;

class Diary extends \core\model\Mysql {

    protected $table = 'diary';

    private static $schema = array(
        'id' , 'text' , 'uid' , 'ctime' , 'utime'
    );

    public function getSchema(){
        return Diary::$schema;
    }
}
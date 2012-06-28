<?php
namespace model;

class User extends \core\model\Mysql {

    protected $table = 'user';

    private static $schema = array(
        'id' , 'email' , 'password' , 'salt' , 'ctime' , 'utime'
    );

    public function schema(){
        return User::$schema;
    }

    public function setEmail( $email ){

    }
}
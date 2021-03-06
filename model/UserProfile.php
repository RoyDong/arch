<?php
namespace model;

class UserProfile extends \core\model\Mysql {

    protected $table = 'user_profile';

    private static $sexes = array( 'm' , 'f' );

    private static $columns = array(
        'uid' , 'name' , 'sex' , 'birth' , 'ctime' , 'utime'
    );

    public function getColumns(){
        return UserProfile::$columns;
    }

    public function getSexes(){
        return UserProfile::$sexes;
    }

    public function setName( $name ){
        $this->data['name'] = $name;
    }

    public function setSex( $sex ){
        if( in_array( $sex , UserProfile::$sexes ) ) $this->data['sex'] = $sex;
    }

    public function setBirth( $birth ){
        $this->data['birth'] = $birth;
    }
}

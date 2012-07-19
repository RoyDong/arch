<?php
namespace model;

class User extends \core\model\Mysql {

    protected $table = 'user';

    private static $columns = array(
        'id' , 'email' , 'password' , 'salt' , 'ctime' , 'utime'
    );

    public function getColumns(){
        return User::$columns;
    }

    public function setEmail( $email ){
        if( $this->isExist( $email ) ) return false;
        $this->data['email'] = $email;
        return true;
    }

    public function checkPassword( $password ){
        if( empty( $this->data['id'] ) )
            throw new \Exception( 'empty user model' );

        return $this->data['password'] ===
                $this->hashPassword( $password , $this->data['salt'] );
    }

    public function setPassword( $password ){
        $salt = uniqid( 'fol' );
        $this->data['password'] = $this->hashPassword( $password , $salt );
        $this->data['salt'] = $salt;
    }

    public function isExist( $email ){
        return (bool)$this->findOne( '`email`="'.$email.'"' );
    }

    private function hashPassword( $password , $salt ){
        return sha1( $password.$salt );
    }
}
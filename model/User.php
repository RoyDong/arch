<?php
namespace model;

class User extends \core\model\Mysql {

    protected $table = 'user';

    private static $schema = array(
        'id' , 'email' , 'password' , 'salt' , 'ctime' , 'utime'
    );

    public function getSchema(){
        return User::$schema;
    }

    public function setEmail( $email ){
        if( $this->isExist( $email ) ) return false;
        $this->data['email'] = $email;
        return true;
    }

    public function checkPassword( $password ){
        if( empty( $this->data['id'] ) )
            throw new \Exception( 'must load data first' );

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

    public function save(){
        $this->data['utime'] = $_SERVER['REQUEST_TIME'];

        if( $this->isNew ){
            $this->data['ctime'] = $_SERVER['REQUEST_TIME'];
            $this->insert( $this->data );
        }else
            $this->update( $this->data , '`id`="'.$this->data['id'].'"' );
    }

    private function hashPassword( $password , $salt ){
        return sha1( $password.$salt );
    }
}
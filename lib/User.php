<?php
namespace lib;

class User {

    private static $pool = array();

    private $user;

    private $profile;

    public static function instance( $id ){
        if( empty( User::$pool[$id] ) ){
            $user = new \model\User;
            if( $user->load( $id ) )
                User::$pool[$id] = new User( $user );
            else
                return;
        }

        return User::$pool[$id];
    }

    public static function signin( $email ){

    }

    private function __construct( \model\User $user ){
        $profile = new \model\UserProfile;
        if( $profile->load( array( 'uid' => $user->id ) ) )
            $this->profile = $profile;

        $this->user = $user;
    }

    public function getData(){

    }
}
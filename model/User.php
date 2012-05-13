<?php
/**
 * article 
 * @author Roy
 */

class User {

    protected $data = array();

    protected $profile = array();

    private static $letters = 'abcdefghijklmnopqrstuvwxyz0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';

    private $isNew = true;

    private $profileLoaded = false;


    public function __construct( $id = 0 ){
        if( $id > 0 ){
            $this->data = Data::getInstance( 'User' )->readOne( '`id`='. $id .'' );
            if( empty( $this->data ) ) throw new Exception( 'user not exist' );
            $this->isNew = false;
        }
    }

    public static function load( $id ){
        if( $id > 0 )
            $data = Data::getInstance( 'User' )->readOne( '`id`='. $id .'' );

        return User::createInstance( $data );
    }

    public static function loadByEmail( $email ){
        $data = Data::getInstance( 'User' )->readOne( '`email`="'. $email .'"' );
        return User::createInstance( $data );
    }

    private static function createInstance( $data ){
        if( empty( $data ) ) throw new Exception( 'user not exists' );

        $user = new User;
        $user->data = $data;
        $user->isNew = false;
        return $user;
    }

    public function __get( $name ){
        if( isset( $this->data[ $name ] ) ) return $this->data[ $name ];
        if( isset( $this->profile[ $name ] ) ) return $this->profile[ $name ];
        if( $name === 'data' ) return $this->data;
        if( $name === 'profile' ) return $this->profile;
        if( $name === 'all' ) return $this->profile + $this->data;

        return '';
    }

    public function setEmail( $email ){
        if( preg_match( '/^[a-zA-Z0-9_\\.]+@[a-zA-Z0-9-]+[\\.a-zA-Z]+$/i' , $email ) ){
            $data = Data::getInstance( 'User' )->readOne( 'email = "' . $email .'"' );
            if( empty( $data ) ){
                $this->data['email'] = $email;
                return true;
            }
            setcookie( 'flash' , 'user exists' );
            return false;
        }
        setcookie( 'flash' , 'wrong email' );
        return false;
    }

    public function setUsername( $username ){
        $this->data['username'] = $username;
        return true;
    }

    public function signin( $password ){
        if( !$this->isNew && $this->data['password'] === $password ){
            $_SESSION['user_id'] = $this->data['id'];
            return true;
        }
        return false;
    }

    public function save(){
        if( $this->isNew ){
            $this->data['password'] = $this->getRndPassword();
            $this->data['created_at'] = $_SERVER['REQUEST_TIME'];
            $this->data['updated_at'] = $_SERVER['REQUEST_TIME'];
            $this->data['id'] = Data::getInstance( 'User' )->insert( $this->data );
        }else{
            $this->data['updated_at'] = $_SERVER['REQUEST_TIME'];
            Data::getInstance( 'User' )
                    ->update( $this->data , '`id`="'.$this->data['id'].'"');
        }
    }

    private function getRndPassword( $length = 8 ){
        $password = '';

        for( $i = 0 ; $i < $length ; $i++ ) 
            $password .= User::$letters[ rand( 0 , 61 ) ];

        return $password;
    }

    public function setOAuthTokenId( $tokenId ){
        $this->data['oauth_token_id'] = $tokenId;
    }

    public function getDefaultWeiboApi(){
        if( !$this->data['oauth_token_id'] ){
            $token = Data::getInstance( 'UserOAuthToken' )
                    ->readOne( '`user_id`="'. $this->data['id'].'"' );

            if( !$token ) return null;

            $this->data['oauth_token_id'] = $token['oauth_token_id'];
            $this->save();
        }

        return WeiboApi::getInstance( $this->data['id'] , $this->data['oauth_token_id'] );
    }

    public function getWeiboList(){
        $list = Data::getInstance( 'User' )->readWeiboList( $this->data['id'] );
        if( empty( $list ) ) return false;
        $api = $this->getDefaultWeiboApi();
        $data = array();


        foreach( $list as $token ){
            $user = $api->user( $token['sns_user_id'] );

            $data[ $token['id'] ] = array(
                'sns_name' => $user['screen_name'],
                'sns_avatar' => $user['profile_image_url'],
                'verified' => $user['verified'],
            );
        }

        return $data;
    }

    public function deleteToken( $tokenId ){
        Data::getInstance( 'UserOAuthToken' )
                ->delete( '`user_id`="'.$this->data['id'].'" and `oauth_token_id`="'.$tokenId.'"' );

        if( $tokenId == $this->data['oauth_token_id'] ){
            $this->data['oauth_token_id'] = '';
            $this->save();
        }
    }
}
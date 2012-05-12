<?php
/**
 * article 
 * @author Roy
 */

class User {

    protected $data = array();

    protected $profile = array();

    public function __construct( $id = 0 ){
        if( $id > 0 ){
            $this->data = Model::getInstance( 'Article' )->fetch( "`id`='$id'" );
            if( empty( $this->data ) ) throw new Exception( 'user not exists' );
        }
    }

    public function __get( $name ){
        if( isset( $this->data[ $name ] ) ) return $this->data[ $name ];
        if( isset( $this->profile[ $name ] ) ) return $this->profile[ $name ];
        if( $name === 'data' ) return $this->data;
        if( $name === 'profile' ) return $this->profile;
        if( $name === 'all' ) return $this->profile + $this->data;
    }
}
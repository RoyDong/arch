<?php
namespace core;

class Message {

    protected $types = array(
        'notice' , 'warning' , 'error'
    );

    protected $data = array();

    public function __get( $type ){
        if( isset( $this->data[$type] ) ) return $this->data[$type];
    }

    public function set( $key , $text , $type = 'notice' ){
        if( is_array( $this->data[$type] ) )
            $this->data[$type][ $key ] = $text;
        else
            $this->data[$type] = array( $key => $text );
    }

    public function setNotice( $key , $text ){
        $this->set( $key , $text , 'notice' );
    }

    public function setWarning( $key , $text ){
        $this->set( $key , $text , 'warning' );
    }

    public function setError( $key , $text ){
        $this->set( $key , $text , 'error' );
    }

    public function get( $key , $type = 'notice' ){
        if( isset( $this->data[$type][$key] ) )
            return $this->data[$type][$key];
    }

    public function getNotice( $key ){
        return $this->get( $key , 'notice' );
    }

    public function getWarning( $key ){
        return $this->get( $key , 'warning' );
    }

    public function getError( $key ){
        return $this->get( $key , 'error' );
    }
}
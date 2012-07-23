<?php
namespace lib;

class Action extends \core\Action {

    protected $user;
    
    public function __construct( $method ){
        $this->method = $method;
        $this->user = \module\User::current();
    }
}
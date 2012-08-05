<?php
namespace lib;

class Action extends \core\Action {

    protected $user;

    public function init(){
        $this->user = \module\User::current();
    }
}
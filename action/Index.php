<?php
namespace action;

class Index extends \core\Action {

    public function get(){
        $user = \model\User::instance($id);
    }
}
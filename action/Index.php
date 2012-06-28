<?php
namespace action;

class Index extends \core\Action {

    public function get(){
        $user = new \model\User;

        $a = isEmail($_GET['e']);
        var_dump($a);
    }
}
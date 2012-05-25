<?php
namespace action\user;

class Show extends \core\Action {

    public function exec(){
        var_dump( $_GET );
    }
}
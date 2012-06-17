<?php
namespace action;

class Index extends \core\Action {

    public function exec(){
        var_dump( $_GET );
    }
}
<?php
namespace core;

abstract class Action {

    public function init(){}

    abstract function exec();

    public function end(){}

    public function error( $message , $code = 0 ){

    }
}
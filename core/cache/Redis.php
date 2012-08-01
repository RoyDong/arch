<?php
namespace core\cache;

class Redis extends \core\Cache {

    public $redis;

    public function __construct( $host , $port , $timeout = 0.5 ){
        $redis = new \Redis;
        $redis->pconnect( $host , $port , $timeout );
    }
}
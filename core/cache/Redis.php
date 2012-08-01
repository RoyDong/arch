<?php
namespace core\cache;

class Redis extends \core\Cache {

    public $redis;

    public function __construct( $host , $port , $timeout = 1 ){
        $this->redis = new \Redis( $host , $port , $timeout );
    }
}
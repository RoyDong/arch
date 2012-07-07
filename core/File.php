<?php
namespace core;

class File {

    private $fp;

    private $file;

    public function __construct( $file , $mode = 'r' ){
        $this->fp = fopen( $file , $mode );
        $this->file = $file;
    }
}
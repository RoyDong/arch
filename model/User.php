<?php
namespace model;

class User extends \core\Model {

    protected $table = 'user';

    private $data;

    public function __construct( $data = array() ){
        $this->data = $data;
    }
}
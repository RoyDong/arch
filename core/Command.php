<?php
namespace core;

class Command {

    protected $action;

    protected $path;

    protected $name;

    protected $host;

    protected $method = 'get';

    protected $time;

    protected $dataType = 'html';

    private static $methods = array(
        'get' , 'set' , 'add' , 'del'
    );

    private static $dataTypes = array(
        'text' , 'html' , 'json' , 'xml'
    );

    public function __construct(){
        $this->path = empty( $_GET['p'] ) ?  '/' : $_GET['p'];
        $this->name = empty( $_GET['n'] ) ? 'index' : $_GET['n'];

        if( isset($_POST['m']) && in_array( $_POST['m'] , Command::$methods ) )
            $this->method = $_POST['m'];

        if( isset($_SERVER['HTTP_DATA_TYPE']) &&
                in_array( $_SERVER['HTTP_DATA_TYPE'] , Command::$dataTypes ) )
            $this->dataType = $_SERVER['HTTP_DATA_TYPE'];

        $this->host = $_SERVER['HTTP_HOST'];
        $this->time = $_SERVER['REQUEST_TIME'];
    }

    public function __get( $name ){
        if( isset( $this->$name ) ) return $this->$name;
    }

    public function exec(){
        $class = '\\action'.str_replace( '/' , '\\' , $this->path )
                .ucfirst( $this->name );

        $this->action = new $class;
        $this->action->init();
        $this->action->{$this->method}();
    }
}
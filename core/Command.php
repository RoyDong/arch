<?php
namespace core;

class Command {

    private $path;

    private $action;

    private $method;

    private static $methods = array(
        'get' , 'put' , 'post' , 'delete'
    );

    public function __construct(){
        $this->path = empty( $_GET['p'] ) ?  '/' : $_GET['p'];
        $this->action = empty( $_GET['a'] ) ? 'index' : $_GET['n'];

        if( isset($_POST['m']) && in_array( $_POST['m'] , Command::$methods ) )
            $this->method = $_POST['m'];
        else
            $this->method = 'get';
    }

    public function __get( $name ){
        if( isset( $this->$name ) ) return $this->$name;
    }

    public function exec(){
        $class = '\\action'. str_replace( '/' , '\\' , $this->path )
                .ucfirst( $this->action );

        $file = ROOT_DIR.'/action'.$this->path.ucfirst( $this->action ).'.php';

        if( file_exists( $file ) ){
            require $file;
            $action = new $class( $this->method );
            if( method_exists( $action , $this->method ) ){
                try{
                    session_start();
                    $action->init();
                    $action->{$this->method}();
                    $action->end();
                }catch( Exception $e ){
                    $action->error( $e->getMessage() , $e->getCode() );
                }
                return;
            }
        }
        echo 'not found';
    }
}
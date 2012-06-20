<?php
namespace core;

class Command {

    private $path;

    private $name;

    private $action;

    private static $actions = array(
        'create' , 'read' , 'update' , 'delete'
    );

    public function __construct(){
        $this->path = empty( $_GET['p'] ) ?  '/' : $_GET['p'];
        $this->name = empty( $_GET['n'] ) ? 'index' : $_GET['n'];

        if( isset($_POST['a']) && in_array( $_POST['a'] , Command::$actions ) )
            $this->action = $_POST['a'];
        else
            $this->action = 'read';
    }

    public function __get( $name ){
        if( isset( $this->$name ) ) return $this->$name;
    }

    public function exec(){
        $class = '\\action'. str_replace( '/' , '\\' , $this->path )
                .ucfirst( $this->name );

        $file = ROOT_DIR.'/action'.$this->path.$this->name.'.php';

        if( file_exists( $file ) ){
            require $file;
            $action = new $class( $this->action );
            if( method_exists( $action , $this->action ) ){
                try{
                    session_start();
                    $action->init();
                    $action->{$this->action}();
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
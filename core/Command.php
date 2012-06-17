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
        $route = c( 'defaultRoute' );
        $this->path = empty( $_GET['p'] ) ?  $route['path'] : $_GET['p'];
        $this->name = empty( $_GET['n'] ) ? $route['action'] : $_GET['n'];

        if( isset($_POST['a']) && in_array( $_POST['a'] , Command::$actions ) )
            $this->action = $_POST['a'];
        else
            $this->action = 'read';
    }

    public function __get( $name ){
        return $this->$name;
    }

    public function exec(){
        $class = '\\action'. str_replace( '/' , '\\' , $this->path )
                .ucfirst( $this->name );

        $classFile = ROOT_DIR.'/action'.$this->path.$this->name.'.php';

        if(file_exists( $classFile )){
            require $classFile;
            $action = new $class;
            try{
                session_start();
                date_default_timezone_set( c('timezone') );
                $action->init();
                $action->{$this->action}();
                $action->end();
            }catch( Exception $e ){
                $action->error( $e->getMessage() , $e->getCode() );
            }
        }else{
            echo 'not found';
        }
    }
}
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

    protected $csrf;

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
        if( empty( $this->$name ) ) 
            return $this->{'get'.ucfirst($name)}();
        else
            return $this->$name;
    }

    public function exec(){
        $class = '\\action'.str_replace( '/' , '\\' , $this->path )
                .ucfirst( $this->name );

        \Arch::getHelp( 'common' );
        $this->action = new $class;
        $this->authenticate();
        $this->action->init();
        $this->action->{$this->method}();
    }

    public function getCsrf(){
        if( empty( $this->csrf ) ){
            $this->csrf = \Arch::$session->csrf;

            if( empty( $this->csrf ) ){
                $this->csrf = sha1( \Arch::$command->time.uniqid( 'fol' ) );
                \Arch::$session->csrf = $this->csrf;
            }
        }

        return $this->csrf;
    }

    public function authenticate(){
        if( $this->method !== 'get' && $this->action->csrfCheck ){
            $csrf = isset( $_POST['ARCH_CSRF'] ) ? $_POST['ARCH_CSRF'] : '';
            if( $csrf !== $this->getCsrf() ){
                $this->dataType = 'text';
                throw new \Exception( 'csrf token error' );
            }
        }
    }
}

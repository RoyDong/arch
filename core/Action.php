<?php
namespace core;

abstract class Action {

    protected $method;

    protected $layout = 'main';

    public function __construct( $method ){
        $this->method = $method;
    }

    public function init(){}

    public function end(){}

    protected function redirect(  $route , $params = array() ){
        header( 'Location: ' . Core::url( $route , $params ) );
        exit;
    }

    protected function render( $_data = array() , $_tpl = null ){
        $_content = $this->getRenderContent( $_data , $_tpl );
        ob_end_clean();

        if( $this->layout )
            require ROOT_DIR.'/template/layout/'.$this->layout.'.php';
        else
            echo $_content;
    }

    protected function renderJson( $_data = array() , $_tpl = null ){
        $_content = $this->getRenderContent( $_data , $_tpl );

        if( $this->layout ){
            require ROOT_DIR.'/template/layout/'.$this->layout.'.php';
            $output = ob_get_contents();    
            ob_end_clean();
        }else
            $output = $_content;

        header( 'Content-Type: application/x-json' );
        echo json_encode(array(
            'scripts' => array(),
            'styleSheets' => array(),
            'data' => $output
        ));
    }

    private function getRenderContent( $_data = array() , $_tpl = null ){
        if( empty($_tpl) )
            $_tpl .= \App::$command->path.\App::$command->action.'.php';
        else if( $_tpl[0] === '/' )
            $_tpl .= $_tpl.'.php';
        else
            $_tpl .= \App::$command->path.$_tpl.'.php';

        $_tpl = ROOT_DIR.'/template'.$_tpl;

        extract( $_data );
        ob_start();
        require $_tpl;
        $content = ob_get_contents();
        ob_clean();
        return $content;
    }

    protected function addScripts( $scripts ){

    }

    protected function addScript(){

    }

    protected function addStyleSheet(){

    }

    protected function addStyleSheets(){

    }

    public function error( $message , $code = 0 ){
        echo $message.' '.$code;
    }
}
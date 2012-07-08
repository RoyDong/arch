<?php
namespace core;

abstract class Action {

    protected $method;

    protected $layout = 'main';

    protected $title = '';

    protected $scripts = array();

    protected $stylesheets = array();

    public function __construct( $method ){
        $this->method = $method;
    }

    public function init(){}

    public function end(){}

    protected function redirect(  $route , $params = array() ){
        header( 'Location: ' . \App::url( $route , $params ) );
        exit;
    }

    protected function render( $_data = array() , $_tpl = null ){
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
        ob_end_clean();

        if( $this->layout )
            require ROOT_DIR.'/template/layout/'.$this->layout.'.php';
        else
            echo $content;
    }

    protected function addScripts( $urls ){
        foreach( $urls as $url ) $this->addScript( $url );
    }

    protected function addScript( $url ){
        array_push( $this->scripts , $url );
    }

    protected function addStylesheet( $url ){
        array_push( $this->stylesheets , $url );
    }

    protected function addStylesheets( $urls ){
        foreach( $urls as $url ) $this->addStylesheet( $url );
    }

    protected function getScripts(){
        $html = '';
        foreach( $this->scripts as $url )
            $html .= '<script type="text/javascript" src="'.$url.'"></script>';

        return $html;
    }

    protected function getStylesheets(){
        $html = '';
        foreach( $this->stylesheets as $url )
            $html .= '<link href="'.$url.'" type="text/css" rel="stylesheet" />';

        return $html;
    }

    public function error( $message , $code = 0 ){
        echo $message.' '.$code;
    }
}
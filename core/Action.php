<?php
namespace core;

class Action {

    protected $method;

    protected $layout = 'main';

    protected $title = '';

    protected $javascripts = array();

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

    protected function render( $data = null , $_tpl = null ){
        if( empty($_tpl) )
            $_tpl .= \App::$command->path.\App::$command->name.'.php';
        else if( $_tpl[0] === '/' )
            $_tpl .= $_tpl.'.php';
        else
            $_tpl .= \App::$command->path.$_tpl.'.php';

        $_tpl = ROOT_DIR.'/template'.$_tpl;

        if( $data ) extract( $data );
        ob_start();
        require $_tpl;
        $content = ob_get_contents();
        ob_end_clean();

        if( $this->layout )
            require ROOT_DIR.'/template/layout/'.$this->layout.'.php';
        else
            echo $content;
    }

    protected function javascript( $url ){
        if( is_array( $url ) )
            foreach( $url as $v )
                array_push( $this->javascripts , $v );
        else
            array_push( $this->javascripts , $url );
    }

    protected function stylesheet( $url ){
        if( is_array( $url ) )
            foreach( $url as $v )
                array_push( $this->stylesheets , $v );
        else
            array_push( $this->stylesheets , $url );
    }

    protected function getJavascripts(){
        $html = '';
        foreach( $this->javascripts as $url )
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
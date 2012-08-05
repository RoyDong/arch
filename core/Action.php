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

        switch( \Arch::$command->dataType ){
            case 'html':
                break;

            case 'text':
                header( 'Content-Type: text/plain; charset=utf-8' );
                break;

            case 'json':
                header( 'Content-Type: application/json; charset=utf-8' );
                break;

            case 'xml':
                header( 'Content-Type: text/xml; charset=utf-8' );
                break;
        }
    }

    public function init(){}

    protected function redirect( $url , $time = 0 ){
        if( $time > 0 )
            header( 'Refresh: '.$time.'; url='.$url );
        else
            header( 'Location: '.$url );

        throw new \Exception( 'finish' );
    }

    protected function render( $_tpl = null , $data = null ){
        ob_start();
        $this->renderPartial( $_tpl , $data );
        $content = ob_get_contents();
        ob_end_clean();

        if( $this->layout )
            require ROOT_DIR.'/template/layout/'.$this->layout.'.php';
        else
            echo $content;
    }

    protected function renderPartial( $_tpl = null , $data = null ){
        if( empty($_tpl) )
            $_tpl = \Arch::$command->path.\Arch::$command->name;
        else if( $_tpl[0] !== '/' )
            $_tpl = \Arch::$command->path.$_tpl;

        if( $data ) extract( $data );
        require ROOT_DIR.'/template'.$_tpl.'.php';
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
            $html .= '<link href="'.$url.'" type="text/css" rel="stylesheet"/>';

        return $html;
    }

    public function error( $e ){
        $this->render( '/error' , array( 'e' => $e ) );
    }
}
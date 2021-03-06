<?php
namespace core;

class Html {

    protected $javascripts = array();

    protected $stylesheets = array();

    public function __get( $name ){
        return $this->{'get'.ucfirst( $name )}();
    }

    public function getFormMethod( $method = 'set' ){
        return '<input type="hidden" name="m" value="'.$method.'"/>'
                .'<input type="hidden" name="ARCH_CSRF" value="'
                .\Arch::$command->csrf.'"/>';
    }

    public function javascript( $url ){
        if( is_array( $url ) )
            foreach( $url as $v )
                array_push( $this->javascripts , $v );
        else
            array_push( $this->javascripts , $url );
    }

    public function stylesheet( $url ){
        if( is_array( $url ) )
            foreach( $url as $v )
                array_push( $this->stylesheets , $v );
        else
            array_push( $this->stylesheets , $url );
    }

    public function getJavascripts(){
        $html = '';
        foreach( $this->javascripts as $url )
            $html .= '<script type="text/javascript" src="'.$url.'"></script>';

        return $html;
    }

    public function getStylesheets(){
        $html = '';
        foreach( $this->stylesheets as $url )
            $html .= '<link href="'.$url.'" type="text/css" rel="stylesheet"/>';

        return $html;
    }
}

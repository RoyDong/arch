<?php
namespace core;

class Action {

    protected $layout = 'main';

    protected $title = '';

    protected $csrfCheck = true;

    protected $csrf;

    private $html;

    public function __construct(){
        if( $this->csrfCheck && $_POST['arch_csrf'] !== $this->getCsrf() )
            throw new \Exception( 'csrf token error' );

        switch( \Arch::$command->dataType ){
            case 'html':
                header( 'Content-Type: text/html; charset=utf-8' );
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

        if( $this->layout ){
            $h = $this->getHtml();
            require ROOT_DIR.'/template/layout/'.$this->layout.'.php';
        }else
            echo $content;
    }

    protected function renderPartial( $_tpl = null , $data = null ){
        if( empty($_tpl) )
            $_tpl = \Arch::$command->path.\Arch::$command->name;
        else if( $_tpl[0] !== '/' )
            $_tpl = \Arch::$command->path.$_tpl;

        if( $data ) extract( $data );
        $h = $this->getHtml();
        require ROOT_DIR.'/template'.$_tpl.'.php';
    }

    protected function getCsrf(){
        if( empty( $this->csrf ) ){
            $this->csrf = \Arch::$session->csrf;

            if( empty( $this->csrf ) ){
                $this->csrf = \sha1( \Arch::$command->time.\uniqid( 'fol' ) );
                \Arch::$session->csrf = $this->csrf;
            }
        }

        return $this->csrf;
    }

    protected function getHtml(){
        if( empty( $this->html ) )
            $this->html = new \core\Html( $this );

        return $this->html;
    }

    public function error( $e ){
        $this->render( '/error' , array( 'e' => $e ) );
    }
}

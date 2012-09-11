<?php
namespace core;

/**
 * Action, consider it a command that can be executed of the project. 
 * that is the reason I use Command as the request handle class. 
 * Any request is a command from user.
 * An action has 4 methods 'get, set, add, del' stands for CRUD operations.
 * Strongly advise as less as possible business logic in action layout.
 * All business logic writen in module layout is recommended, especially
 * those reusable. 
 * 
 * @author Roy
 */
class Action {

    /**
     * @var string
     */
    protected $layout = 'main';

    /**
     * @var string
     */
    protected $title = '';

    /**
     * @var string
     */
    private $theme = '';

    /**
     * @var \core\Html
     */
    private $html;

    /**
     * constructor
     * 
     * Still considering the necessity, maybe someone could told me?
     */
    public function __construct(){
        switch( \Arch::$command->dataType ){
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

    /**
     * before running the action method, you can do some pre-execution.
     */
    public function init(){}

    /**
     * redirect user, and stop php script.
     * 
     * @param string $url
     * @param int $time
     * @throws \Exception finish exception 
     * @see \Arch::exception
     */
    protected function redirect( $url , $time = 0 ){
        if( $time > 0 )
            header( 'Refresh: '.$time.'; url='.$url );
        else
            header( 'Location: '.$url );

        throw new \Exception( 'finish' );
    }

    /**
     * render html templates.
     * 
     * @param string $_tpl template file path see \Action::renderPartial
     * @param array $data data variables used in template
     */
    protected function render( $_tpl = null , $data = null ){
        ob_start();
        $this->renderPartial( $_tpl , $data );
        $content = ob_get_contents();
        ob_end_clean();

        if( $this->layout ){
            $h = $this->getHtml();
            require ROOT_DIR.'/tpl'.$this->theme.'/layout/'.
                    $this->layout.'.php';
        }else
            echo $content;
    }

    /**
     * render partial template.
     * 
     * @param string $_tpl template file path
     *  if not started with '/', command path will automatically added 
     *      in the front.
     *  if empty, current action file path will used as the template path.
     * 
     *  note must using full path in template, unless the template is used
     *      only in one place.
     * 
     * @param array $data 
     */
    protected function renderPartial( $_tpl = null , $data = null ){
        if( empty($_tpl) )
            $_tpl = \Arch::$command->path.\Arch::$command->name;
        else if( $_tpl[0] !== '/' )
            $_tpl = \Arch::$command->path.$_tpl;

        if( $data ) extract( $data );
        unset( $data );
        $h = $this->getHtml();
        require ROOT_DIR.'/tpl'.$this->theme.$_tpl.'.php';
    }

    /**
     * get singleton instance
     * 
     * @return \core\Html
     */
    protected function getHtml(){
        if( empty( $this->html ) )
            $this->html = new \core\Html;

        return $this->html;
    }

    /**
     * set theme for template
     * 
     * @param string $name 
     */
    protected function setTheme( $name ){
        if( $name )
            $this->theme = '/'.$name;
        else
            $this->theme = '';
    }

    /**
     * error handler
     * 
     * @see \Arch::exception
     * @param \Exception $e 
     */
    public function error( $e ){
        $this->render( '/error' , array( 'e' => $e ) );
    }
}
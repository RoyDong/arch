<?php
namespace core;

/**
 * Command or Request, handle http requests.
 * need nginx rewrite for routing, see ROOT_DIR/conf/rewrite.nginx
 * 
 *  url rule: 
 *      url format: http://{host}{path}{name} 
 *      path will rewrite to $_GET['p'] defaults /
 *      name will rewrite to $_GET['n'] defaults index
 *      note the first and the last slash is required in path 
 * 
 * @author Roy 
 */
class Command {

    /**
     * @var \core\Action
     */
    protected $action;

    /**
     * @var string action class file path
     */
    protected $path;

    /**
     * @var string action name
     */
    protected $name;

    /**
     * @var string website host
     */
    protected $host;

    /**
     * @var string request type: get, set, add, del.
     */
    protected $method = 'get';

    /**
     * @var int request time
     */
    protected $time;

    /**
     * @var string response data type
     */
    protected $dataType = 'default';

    /**
     * @var string csrf token
     */
    protected $csrf;

    private static $methods = array(
        'set' , 'add' , 'del'
    );

    private static $dataTypes = array(
        'txt' , 'json' , 'xml'
    );

    /**
     * constructor 
     */
    public function __construct(){
        $this->path = empty( $_GET['p'] ) ?  '/' : $_GET['p'];
        $this->name = empty( $_GET['n'] ) ? 'index' : $_GET['n'];

        if( isset($_POST['m']) && in_array( $_POST['m'] , Command::$methods ) )
            $this->method = $_POST['m'];

        if( !empty($_GET['f']) ){
            if( $_GET['f'][0] === '.' )
                $dataType = ltrim($_GET['f'], '.');
            else
                $dataType = ltrim($_GET['f'], 'index.');

            if( in_array( $dataType , Command::$dataTypes ) )
                $this->dataType = $dataType;
        }

        $this->host = $_SERVER['HTTP_HOST'];
        $this->time = $_SERVER['REQUEST_TIME'];
    }

    public function __get( $name ){
        if( isset( $this->$name ) )
            return $this->$name;
        else
            return $this->{'get'.ucfirst($name)}();
    }

    /**
     * initialize action and run method 
     */
    public function exec(){
        $class = '\\action'.str_replace( '/' , '\\' , $this->path )
                .ucfirst( $this->name );

        /**
         * load default helper 
         */
        \Arch::help( 'arch' );
        $this->action = new $class;
        $this->action->init();
        $this->action->{$this->method}();
    }

    /**
     * get csrf token, if empty, create it and store in session.
     * 
     * @return string
     */
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
}

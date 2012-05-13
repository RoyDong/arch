<?php

/**
 * Restfull api protocol, base class for all third part api protocol, such as oauth
 * Modify from sina weibo php sdk
 * @author Roy
 */
class RestProtocol {

    /**
     * Contains the last HTTP status code returned. 
     *
     * @ignore
     */
    protected $http_code;
    protected $host;

    /**
     * Contains the last API call.
     *
     * @ignore
     */
    protected $url;

    /**
     * Set timeout default.
     *
     * @ignore
     */
    protected $timeout = 30;

    /**
     * Set connect timeout.
     *
     * @ignore
     */
    protected $connecttimeout = 30;

    /**
     * Verify SSL Cert.
     *
     * @ignore
     */
    protected $ssl_verifypeer = FALSE;

    /**
     * Respons format.
     *
     * @ignore
     */
    protected $format = '';

    /**
     * Decode returned json data.
     *
     * @ignore
     */
    protected $decode_json = TRUE;

    /**
     * Contains the last HTTP headers returned.
     *
     * @ignore
     */
    protected $http_info;

    /**
     * Set the useragnet.
     *
     * @ignore
     */
    protected $useragent = 'Sidways Patrick REST 0.1';

    /**
     * print the debug info
     *
     * @ignore
     */
    protected $debug = FALSE;

    /**
     * http headers
     * @var array
     */
    protected $headers = array( );

    /**
     * boundary of multipart
     * @ignore
     */
    protected static $boundary = '';

    public function setHeaders( $header ){
        $this->headers[ ] = $header;
    }

    public function setHost( $host ){
        $this->host;
    }

    /**
     * GET wrappwer for request.
     *
     * @return mixed
     */
    public function get( $url , $parameters = array( ) ){
        return $this->request( $url , 'get' , $parameters );
    }

    /**
     * POST wreapper for request.
     *
     * @return mixed
     */
    public function post( $url , $parameters = array( ) , $multi = false ){
        return $this->request( $url , 'post' , $parameters , $multi );
    }

    function delete( $url , $parameters = array( ) ){
        return $this->request( $url , 'delete' , $parameters );
    }

    /**
     * Format and sign an OAuth / API request
     *
     * @return string
     * @ignore
     */
    public function request( $url , $method , $parameters , $multi = false ){
        if( strrpos( $url , 'http://' ) !== 0 && strrpos( $url , 'https://' ) !== 0 ){
            $url = "{$this->host}{$url}";
        }

        switch( $method ){
            case 'get':
                $url = $url . '?' . http_build_query( $parameters );
                return $this->http( $url , 'get' );
            default:
                $headers = array( );
                if( !$multi && (is_array( $parameters ) || is_object( $parameters )) ){
                    $body = http_build_query( $parameters );
                }else{
                    $body = self::build_http_query_multi( $parameters );
                    $headers[ ] = "Content-Type: multipart/form-data; boundary=" . self::$boundary;
                }
                return $this->http( $url , $method , $body , $headers );
        }
    }

    /**
     * Make an HTTP request
     *
     * @return string API results
     * @ignore
     */
    public function http( $url , $method , $postfields = NULL , $headers = array( ) ){
        $this->http_info = array( );
        $ci = curl_init();
        /* Curl settings */
        curl_setopt( $ci , CURLOPT_HTTP_VERSION , CURL_HTTP_VERSION_1_0 );
        curl_setopt( $ci , CURLOPT_USERAGENT , $this->useragent );
        curl_setopt( $ci , CURLOPT_CONNECTTIMEOUT , $this->connecttimeout );
        curl_setopt( $ci , CURLOPT_TIMEOUT , $this->timeout );
        curl_setopt( $ci , CURLOPT_RETURNTRANSFER , TRUE );
        curl_setopt( $ci , CURLOPT_ENCODING , "" );
        curl_setopt( $ci , CURLOPT_SSL_VERIFYPEER , $this->ssl_verifypeer );
        curl_setopt( $ci , CURLOPT_HEADERFUNCTION , array( $this , 'getHeader' ) );
        curl_setopt( $ci , CURLOPT_HEADER , FALSE );

        switch( $method ){
            case 'post':
                curl_setopt( $ci , CURLOPT_POST , TRUE );
                if( !empty( $postfields ) ){
                    curl_setopt( $ci , CURLOPT_POSTFIELDS , $postfields );
                    $this->postdata = $postfields;
                }
                break;
            case 'delete':
                curl_setopt( $ci , CURLOPT_CUSTOMREQUEST , 'DELETE' );
                if( !empty( $postfields ) ){
                    $url = "{$url}?{$postfields}";
                }
        }

        curl_setopt( $ci , CURLOPT_URL , $url );
        curl_setopt( $ci , CURLOPT_HTTPHEADER , $this->headers );
        curl_setopt( $ci , CURLINFO_HEADER_OUT , TRUE );
        $response = curl_exec( $ci );
        $this->http_code = curl_getinfo( $ci , CURLINFO_HTTP_CODE );
        $this->http_info = array_merge( $this->http_info , curl_getinfo( $ci ) );
        $this->url = $url;
        curl_close( $ci );

        return $response;
    }

    /**
     * Get the header info to store.
     *
     * @return int
     * @ignore
     */
    public function getHeader( $ch , $header ){
        $i = strpos( $header , ':' );
        if( !empty( $i ) ){
            $key = str_replace( '-' , '_' , strtolower( substr( $header , 0 , $i ) ) );
            $value = trim( substr( $header , $i + 2 ) );
            $this->http_header[ $key ] = $value;
        }
        return strlen( $header );
    }

    /**
     * @ignore
     */
    public static function build_http_query_multi( $params ){
        if( !$params )
            return '';

        uksort( $params , 'strcmp' );

        $pairs = array( );

        self::$boundary = $boundary = uniqid( '------------------' );
        $MPboundary = '--' . $boundary;
        $endMPboundary = $MPboundary . '--';
        $multipartbody = '';

        foreach( $params as $parameter => $value ){

            if( in_array( $parameter , array( 'pic' , 'image' ) ) && $value{0} == '@' ){
                $url = ltrim( $value , '@' );
                $content = file_get_contents( $url );
                $array = explode( '?' , basename( $url ) );
                $filename = $array[ 0 ];

                $multipartbody .= $MPboundary . "\r\n";
                $multipartbody .= 'Content-Disposition: form-data; name="' . $parameter . '"; filename="' . $filename . '"' . "\r\n";
                $multipartbody .= "Content-Type: image/unknown\r\n\r\n";
                $multipartbody .= $content . "\r\n";
            }else{
                $multipartbody .= $MPboundary . "\r\n";
                $multipartbody .= 'content-disposition: form-data; name="' . $parameter . "\"\r\n\r\n";
                $multipartbody .= $value . "\r\n";
            }
        }

        return $multipartbody . $endMPboundary;
    }
}

abstract class OAuthProtocolV1 extends RestProtocol{

    protected $user_id;
    protected $access_token = '';
    protected $token_secret = '';
    protected $format = '';

    /**
     * @return string request token url
     */
    abstract protected function requestTokenUrl();

    /**
     * @return string app key
     */
    abstract protected function appKey();

    /**
     * @return string app secret key
     */
    abstract protected function secretKey();

    /**
     * @return string authorize url
     */
    abstract protected function authorizeUrl();

    /**
     * @return string access token url
     */
    abstract protected function accessTokenUlr();

    /**
     * @return string get user's sns id
     */
    abstract protected function getSnsUserIdFromToken( $token );

    /**
     * get request token
     * @return array
     */
    public function getRequestToken(){//default to string null if no callback
        $config = c('weibo');
        $params = array(
            'oauth_consumer_key' => $this->appKey() ,
            'oauth_signature_method' => 'HMAC-SHA1' ,
            'oauth_timestamp' => $_SERVER[ 'REQUEST_TIME' ] ,
            'oauth_nonce' => self::randStr() ,
            'oauth_callback' => $config['callback'],
            'oauth_version' => '1.0'
        );

        $params[ 'oauth_signature' ] = $this->getSignature( $this->requestTokenUrl() , 'GET' , $params );
        $response = $this->get( $this->requestTokenUrl() , $params );
        $token = $this->getQueryParams( $response );

        if( empty( $token[ 'oauth_token' ] ) ){
            throw new Exception( $response );
        }

        return $token;
    }

    /**
     * get authorize url
     * @param type $a
     * @param type $b
     * @param type $c
     * @return string authorize url
     */
    public function getAuthorizeUrl( $forcelogin = true ){
        $token = $this->getRequestToken();
        $config = c('weibo');
        $_SESSION['oauth_token_tmp'] = $token;

        $url = $this->authorizeUrl() . '?oauth_token=' . $token[ 'oauth_token' ];
        $url .= '&oauth_callback=http://' . $_SERVER['HTTP_HOST'] . urlencode( $config['callback'] );
        if( $forcelogin ) $url .= '&forcelogin=true';

        return $url;
    }

    /**
     * callback after user authorizion.
     * @param type $code 
     */
    public function callback( $code ){
        $tmpToken = $_SESSION['oauth_token_tmp'];
        $this->access_token = $tmpToken['oauth_token'];
        $this->token_secret = $tmpToken['oauth_token_secret'];

        $params = $this->getOAuthParams();
        $params[ 'oauth_verifier' ] = $code;
        $params[ 'oauth_signature' ] = $this->getSignature( $this->accessTokenUlr() , 'GET' , $params );
        $response = $this->get( $this->accessTokenUlr() , $params );
        $token = $this->getQueryParams( $response );

        if( empty( $token[ 'oauth_token' ] ) )
            throw new Exception( $response );

        $this->access_token = $token[ 'oauth_token' ];
        $this->token_secret = $token[ 'oauth_token_secret' ];
        return $this->saveToken( $token );
    }

    /**
     * get oauth 1.0 common params
     * @return array
     */
    protected function getOAuthParams(){
        return array(
            'oauth_consumer_key' => $this->appKey() ,
            'oauth_token' => $this->access_token ,
            'oauth_signature_method' => 'HMAC-SHA1' ,
            'oauth_timestamp' => $_SERVER[ 'REQUEST_TIME' ] ,
            'oauth_nonce' => self::randStr() ,
            'oauth_version' => '1.0' ,
        );
    }

    /**
     * parse string
     * @param string $query_string
     * @return array
     */
    protected function getQueryParams( $query_string ){
        $parts = explode( '&' , $query_string );
        $params = array( );

        foreach( $parts as $part ){
            $pair = explode( '=' , $part );
            $params[ $pair[ 0 ] ] = $pair[ 1 ];
        }

        return $params;
    }

    /**
     * save token to local db
     * @param array $token 
     */
    protected function saveToken( $token ){
        $localToken = Data::getInstance( 'OAuthToken' )
                ->readOne( 'sns_user_id='.$token['user_id'].' and sns="weibo"' );

        if( empty( $localToken) ){
            $localToken = array(
                'sns' => 'weibo',
                'sns_user_id' => $token['user_id'],
                'access_token' => $token['oauth_token'],
                'secret_token' => $token['oauth_token_secret'],
                'created_at' => $_SERVER['REQUEST_TIME'],
                'updated_at' => $_SERVER['REQUEST_TIME'],
            );
            $localToken['id'] = Data::getInstance( 'OAuthToken' )->insert( $localToken );
        }

        Data::getInstance( 'UserOAuthToken' )->insert(array(
            'user_id' => $this->user_id,
            'oauth_token_id' => $localToken['id'],
            'created_at' => $_SERVER['REQUEST_TIME'],
            'updated_at' => $_SERVER['REQUEST_TIME'],
        ));

        return $localToken['id'];
    }

    /**
     * generate oauth 1.0 signatrue
     * @param type $url
     * @param type $method
     * @param type $params
     * @return string
     */
    public function getSignature( $url , $method , $params ){
        uksort( $params , 'strcmp' );
        $pairs = array( );

        foreach( $params as $key => $value ){
            $key = self::urlencode_rfc3986( $key );
            if( is_array( $value ) ){
                // If two or more parameters share the same name, they are sorted by their value
                // Ref: Spec: 9.1.1 (1)
                natsort( $value );
                foreach( $value as $duplicate_value ){
                    $pairs[ ] = $key . '=' . self::urlencode_rfc3986( $duplicate_value );
                }
            }else{
                $pairs[ ] = $key . '=' . self::urlencode_rfc3986( $value );
            }
        }

        $sign_parts = self::urlencode_rfc3986( implode( '&' , $pairs ) );
        $base_string = implode( '&' , array( strtoupper( $method ) , self::urlencode_rfc3986( $url ) , $sign_parts ) );
        $key = self::urlencode_rfc3986( $this->secretKey() ) . '&' . self::urlencode_rfc3986( $this->token_secret );
        $sign = base64_encode( self::hash_hmac( 'sha1' , $base_string , $key , true ) );

        return $sign;
    }

    /**
     * rfc3986 encode
     * why not encode ~
     *
     * @param string|mix $input
     * @return string
     */
    public static function urlencode_rfc3986( $input ){
        if( is_array( $input ) ){
            return array_map( array( __CLASS__ , 'urlencode_rfc3986' ) , $input );
        }else if( is_scalar( $input ) ){
            return str_replace( '%7E' , '~' , rawurlencode( $input ) );
        }else{
            return '';
        }
    }

    /**
     * fix hash_hmac
     *
     * @see hash_hmac
     * @param string $algo
     * @param string $data
     * @param string $key
     * @param bool $raw_output
     */
    public static function hash_hmac( $algo , $data , $key , $raw_output = false ){
        if( function_exists( 'hash_hmac' ) ){
            return hash_hmac( $algo , $data , $key , $raw_output );
        }

        $algo = strtolower( $algo );
        if( $algo == 'sha1' ){
            $pack = 'H40';
        }elseif( $algo == 'md5' ){
            $pach = 'H32';
        }else{
            return '';
        }
        $size = 64;
        $opad = str_repeat( chr( 0x5C ) , $size );
        $ipad = str_repeat( chr( 0x36 ) , $size );

        if( strlen( $key ) > $size ){
            $key = str_pad( pack( $pack , $algo( $key ) ) , $size , chr( 0x00 ) );
        }else{
            $key = str_pad( $key , $size , chr( 0x00 ) );
        }

        for( $i = 0; $i < strlen( $key ) - 1; $i++ ){
            $opad[ $i ] = $opad[ $i ] ^ $key[ $i ];
            $ipad[ $i ] = $ipad[ $i ] ^ $key[ $i ];
        }

        $output = $algo( $opad . pack( $pack , $algo( $ipad . $data ) ) );

        return ($raw_output) ? pack( $pack , $output ) : $output;
    }

    /**
     * get a random string
     * @staticvar string $pattern
     * @param type $length
     * @return string
     */
    public static function randStr( $length = 32 ){
        static $pattern = '1234567890abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $string = '';

        for( $i = 0; $i < $length; $i++ ){
            $string .= $pattern[ rand( 0 , 61 ) ];
        }

        return $string;
    }
}

class OAuthSinaWeibo extends OAuthProtocolV1 {

    protected static $app_key;
    protected static $secret_key;

    /**
     * Set up the API root URL.
     *
     * @ignore
     */
    protected $host = "http://api.t.sina.com.cn/";

    /**
     * Set the useragnet.
     *
     * @ignore
     */
    protected $useragent = 'Tencent Weibo OAuth v0.1';

    public function __construct( $user_id , $app_key , $secret_key , $access_token = null , $token_secret = null ){
        if( empty( self::$app_key ) )
            self::$app_key = $app_key;

        if( empty( self::$secret_key ) )
            self::$secret_key = $secret_key;

        $this->user_id = $user_id;
        $this->access_token = $access_token;
        $this->token_secret = $token_secret;
        $this->format = 'json';
    }

    public function call( $url , $method , $parameters , $multi = false ){
        $parameters[ 'format' ] = $this->format;
        $parameters = array_merge( $parameters , $this->getOAuthParams() );
        $parameters[ 'oauth_signature' ] = $this->getSignature( $this->host . $url , $method , $parameters );
        $response = $this->request( $url , $method , $parameters , $multi );
        $response = json_decode( $response , true );

        if( is_array( $response ) && empty( $response[ 'errcode' ] ) ){
            return $response;
        }

        throw new Exception( $response[ 'msg' ] );
    }

    protected function getSnsUserIdFromToken( $token ){
        return isset( $token[ 'name' ] ) ? $token[ 'name' ] : 0;
    }

    protected function appKey(){
        return self::$app_key;
    }

    protected function secretKey(){
        return self::$secret_key;
    }

    protected function requestTokenUrl(){
        return'http://api.t.sina.com.cn/oauth/request_token';
    }

    protected function authorizeUrl(){
        return'http://api.t.sina.com.cn/oauth/authorize';
    }

    protected function accessTokenUlr(){
        return 'http://api.t.sina.com.cn/oauth/access_token';
    }
}


class WeiboApi {

    private $oauth;

    private $userId;

    private static $instances = array();

    public static function getInstance( $userId , $tokenId ){
        if( isset( WeiboApi::$instances[$userId][$tokenId] ) )
            return WeiboApi::$instances[$userId][$tokenId];

        $where = '`user_id`="' . $userId . '" and `oauth_token_id`="' . $tokenId . '"';

        if( Data::getInstance( 'UserOAuthToken' )->count( $where ) == 0 )
            throw new Exception( 'token is not binded' );

        $token = Data::getInstance( 'OAuthToken' )->readOne( '`id`="' . $tokenId .'"' );

        if( $token ){
            $api = new WeiboApi;
            $config = c('weibo');
            $api->userId = $userId;
            $api->oauth = new OAuthSinaWeibo( $userId ,$config['appKey'] , 
                    $config['secretKey'] , 
                    $token['access_token'] , 
                    $token['secret_token'] );

            return WeiboApi::$instances[$userId][$tokenId] = $api;
        }
        throw new Exception( 'token not found' );
    }

    public static function bindOauth( $userId ){
        $config = c('weibo');
        return new OAuthSinaWeibo( $userId , $config['appKey'] , $config['secretKey'] ); 
    }

    public function user( $userId ){
        $params = array(
            'user_id' => $userId
        );
                
        return $this->oauth->call( 'users/show.json' , 'get' , $params );
    }

    public function friendsTimeline( $page = 1 , $count = 50 ){
        $params = array(
            'count' => $count,
            'page' => $page
        );

        return $this->oauth->call( 'statuses/friends_timeline.json' , 'get' , $params );
    }
}
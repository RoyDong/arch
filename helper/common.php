<?php

function dump( $var , $html = false ){
    if( $html ){
        echo '<pre>';
        print_r( $var );
    }else
        file_put_contents( ROOT_DIR.'/log/debug.log' , 
                var_export( $var , true ) . "\n\n" , FILE_APPEND );
}

function isEmail( $email ){
    return preg_match( '/^[\w\._\-]+@[\w\.\-_]*[\w\-_]\.[a-z]{2,4}$/i' , $email );
}
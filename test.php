<?php

$url = '/index.php/sdfsdf/sdfsdfsf/index.php';

$start = microtime();
for( $i = 0 ; $i < 1000 ; $i++ ){
    str_replace( '/index.php' , '' , $url );
}
$end = microtime();

var_dump( $end - $start );

$start = microtime();
for( $i = 0 ; $i < 1000 ; $i++ ){
    preg_replace( '/^\/index.php/i' , '' , $url );
}
$end = microtime();
var_dump( $end - $start );

$a = array( 'a' , '3' , 33 ,55 );

var_dump( each( $a ) );
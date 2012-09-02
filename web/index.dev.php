<?php
ini_set( 'display_errors' , 1 );
error_reporting( E_ALL );

define( 'ENVIRONMENT' , 'development' );
define( 'DEBUG' , isset( $_GET['debug'] ) );
define( 'ROOT_DIR' , dirname( __DIR__ ) );
require ROOT_DIR.'/arch.php';
Arch::run();
<?php
define( 'ENVIRONMENT' , 'production' );
define( 'DEBUG' , isset( $_GET['debug'] ) );
define( 'ROOT_DIR' , dirname( __DIR__ ) );
require ROOT_DIR . '/arch.php';
Arch::run();

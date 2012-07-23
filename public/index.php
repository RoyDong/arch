<?php
define( 'ENVIRONMENT' , 'production' );
define( 'DEBUG' , false );
define( 'ROOT_DIR' , dirname( __DIR__ ) );
require ROOT_DIR . '/core.php';
App::run();

<?php
define( 'ENV' , 'production' );
define( 'ROOT_DIR' , dirname( __DIR__ ) );
require ROOT_DIR . '/Core.php';
App::run();

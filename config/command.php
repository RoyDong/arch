<?php

/**
 * commands
 */

return array(
    '/user/:number' => array( 'path' => '/user/' , 'action' => 'show' , 'id' ),

    '/user/:word/:number' => array( 'path' => '/user/' , 'action' => 'show' , 'type' , 'id' ),

    '/user/:number/edit' => array( 'path' => '/user/' , 'action' => 'edit' , 'id' ),
);
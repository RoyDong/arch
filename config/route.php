<?php

/**
 * route tree 
 */

return array(
    '_int' => 'show',

    'show' => true,
    'user' => array(
        'show' => true,
        'edit' => true,
    ),

    'weibo' => array(
        'user' => array(
            'show' => true,
            'edit' => true,
        ),

        'write' => true,

        'show' => true,
    ),
);
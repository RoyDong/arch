<?php
return array(
    'db' => array(
        'dsn' => 'mysql:host=192.168.11.32;port=3306;dbname=patrick;charset=utf8' ,
        'username' => 'patrick_admin',
        'password' => 'patrick',
        'tablePrefix' => 'ew_',
    ),

    'weibo' => array(
        'appKey' => 3378977054,
        'secretKey' => 'c0c3e93126439a890c92460113d683ad',
        'callback' => '/index.php?m=weibo&a=callback',
    ),
);
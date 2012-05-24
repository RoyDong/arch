<?php
return array(
    'db' => array(
        'dsn' => 'mysql:host=127.0.0.1;port=3306;dbname=enterpriseweibo;charset=utf8',
        'username' => 'root',
        'password' => '111lll',
        'tablePrefix' => 'ew_',
    ),

    'weibo' => array(
        'appKey' => 3378977054,
        'secretKey' => 'c0c3e93126439a890c92460113d683ad',
        'callback' => '/weibo/callback',
    ),

    'hideScriptName' => true,

    'timezone' => 'Asia/Shanghai',
);

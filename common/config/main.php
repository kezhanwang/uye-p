<?php
require(__DIR__ . DIRECTORY_SEPARATOR . "exception.php");
require(__DIR__ . DIRECTORY_SEPARATOR . "constant.php");

return [
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'name' => 'U业',
    'language'=>'zh-CN',
    'components' => [
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],

        'db' => [
            'class' => 'yii\db\Connection',
            'dsn' => 'mysql:host=123.57.138.234;dbname=uye',
            'username' => 'kz',
            'password' => 'DB_root_#yulan#',
            'charset' => 'utf8',
        ],

        'db2' => [
            'class' => 'yii\db\Connection',
            'dsn' => 'mysql:host=123.57.138.234;dbname=kz',
            'username' => 'kz',
            'password' => 'DB_root_#yulan#',
            'charset' => 'utf8',
        ],
    ],
];

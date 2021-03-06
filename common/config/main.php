<?php
require(__DIR__ . DIRECTORY_SEPARATOR . "exception.php");
require(__DIR__ . DIRECTORY_SEPARATOR . "constant.php");

return [
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'name' => 'U业帮',
    'language' => 'zh-CN',
    'components' => [
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'db' => require PATH_BASE . DIRECTORY_SEPARATOR . "config" . DIRECTORY_SEPARATOR . "db.php",
        'log' => require PATH_BASE . DIRECTORY_SEPARATOR . "config" . DIRECTORY_SEPARATOR . "log.php",

        'language' => 'zh-CN',
    ],
];

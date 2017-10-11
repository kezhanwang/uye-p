<?php
require(__DIR__ . DIRECTORY_SEPARATOR . "exception.php");
require(__DIR__ . DIRECTORY_SEPARATOR . "constant.php");

return [
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'name' => 'U业',
    'language' => 'zh-CN',
    'components' => [
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],

        
    ],
];

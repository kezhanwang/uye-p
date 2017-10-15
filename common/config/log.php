<?php
/**
 * Created by PhpStorm.
 * User: wangyi
 * Date: 2017/10/15
 * Time: 上午10:48
 */

return [
    'traceLevel' => YII_DEBUG ? 3 : 0,
    'targets' => [
        [
            'class' => 'yii\log\FileTarget',
            'levels' => ['error', 'warning'],
        ],
        [
            'class' => 'yii\log\FileTarget',
            'levels' => ['error', 'warning'],
            'categories' => ['echo'],
            'logFile' => '@app/runtime/logs/echo.log',
            'maxFileSize' => 102400,
            'maxLogFiles' => 30,
        ],
        [
            'class' => 'yii\log\FileTarget',
            'levels' => ['error', 'warning'],
            'categories' => ['echo'],
            'logFile' => '@app/runtime/logs/db.log',
            'maxFileSize' => 102400,
            'maxLogFiles' => 30,
        ],
    ],
];
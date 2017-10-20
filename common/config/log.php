<?php
/**
 * Created by PhpStorm.
 * User: wangyi
 * Date: 2017/10/15
 * Time: 上午10:48
 */

return [
    'traceLevel' =>  0,
    'targets' => [
        [
            'class' => 'yii\log\FileTarget',
            'levels' => ['error', 'warning'],
            'logFile' => '@app/runtime/logs/' . date('Ymd') . '/app.log',
            'maxFileSize' => 102400,
            'maxLogFiles' => 30,
        ],
        [
            'class' => 'yii\log\FileTarget',
            'levels' => ['error', 'warning'],
            'categories' => ['echo'],
            'logFile' => '@app/runtime/logs/' . date('Ymd') . '/echo.log',
            'maxFileSize' => 102400,
            'maxLogFiles' => 30,
        ],
        [
            'class' => 'yii\log\FileTarget',
            'levels' => ['error', 'warning'],
            'categories' => ['echo'],
            'logFile' => '@app/runtime/logs/' . date('Ymd') . '/db.log',
            'maxFileSize' => 102400,
            'maxLogFiles' => 30,
        ],
        [
            'class' => 'yii\log\FileTarget',
            'levels' => ['error', 'warning', 'info'],
            'categories' => ['databus'],
            'logFile' => '@app/runtime/logs/' . date('Ymd') . '/databus.log',
            'maxFileSize' => 102400,
            'maxLogFiles' => 30,
        ],
        [
            'class' => 'yii\log\FileTarget',
            'levels' => ['error', 'warning', 'info'],
            'categories' => ['login'],
            'logFile' => '@app/runtime/logs/' . date('Ymd') . '/login.log',
            'maxFileSize' => 102400,
            'maxLogFiles' => 30,
        ],
        [
            'class' => 'yii\log\FileTarget',
            'levels' => ['error', 'warning', 'info'],
            'categories' => ['upload_file'],
            'logFile' => '@app/runtime/logs/' . date('Ymd') . '/upload_file.log',
            'maxFileSize' => 102400,
            'maxLogFiles' => 30,
        ],
    ],
];
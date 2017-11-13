<?php
/**
 * Created by PhpStorm.
 * User: wangyi
 * Date: 2017/10/15
 * Time: 上午10:48
 */

return [
    'traceLevel' => 0,
    'targets' => [
        [
            'class' => 'yii\log\FileTarget',
            'levels' => ['error'],
            'logFile' => '@app/runtime/logs/' . date('Ymd') . '/app.log',
            'maxFileSize' => 102400,
            'maxLogFiles' => 30,
        ],
        [
            'class' => 'yii\log\FileTarget',
            'levels' => ['error', 'warning'],
            'logVars' => [],
            'categories' => ['echo'],
            'logFile' => '@app/runtime/logs/' . date('Ymd') . '/echo.log',
            'maxFileSize' => 102400,
            'maxLogFiles' => 30,
        ],
        [
            'class' => 'yii\log\FileTarget',
            'levels' => ['error', 'warning'],
            'categories' => ['db'],
            'logVars' => [],
            'logFile' => '@app/runtime/logs/' . date('Ymd') . '/db.log',
            'maxFileSize' => 102400,
            'maxLogFiles' => 30,
        ],
        [
            'class' => 'yii\log\FileTarget',
            'levels' => ['error', 'warning', 'info'],
            'categories' => ['databus'],
            'logVars' => [],
            'logFile' => '@app/runtime/logs/' . date('Ymd') . '/databus.log',
            'maxFileSize' => 102400,
            'maxLogFiles' => 30,
        ],
        [
            'class' => 'yii\log\FileTarget',
            'levels' => ['error', 'warning', 'info'],
            'logVars' => [],
            'categories' => ['login'],
            'logFile' => '@app/runtime/logs/' . date('Ymd') . '/login.log',
            'maxFileSize' => 102400,
            'maxLogFiles' => 30,
        ],
        [
            'class' => 'yii\log\FileTarget',
            'levels' => ['error', 'warning', 'info'],
            'categories' => ['upload_file'],
            'logVars' => [],
            'logFile' => '@app/runtime/logs/' . date('Ymd') . '/upload_file.log',
            'maxFileSize' => 102400,
            'maxLogFiles' => 30,
        ],
        [
            'class' => 'yii\log\FileTarget',
            'levels' => ['error', 'warning', 'info'],
            'categories' => ['insured_order'],
            'logFile' => '@app/runtime/logs/' . date('Ymd') . '/insured_order.log',
            'maxFileSize' => 102400,
            'maxLogFiles' => 30,
        ],
        [
            'class' => 'yii\log\FileTarget',
            'levels' => ['error', 'warning', 'info'],
            'categories' => ['udcredit'],
            'logFile' => '@app/runtime/logs/' . date('Ymd') . '/udcredit.log',
            'maxFileSize' => 102400,
            'maxLogFiles' => 30,
        ],
    ],
];
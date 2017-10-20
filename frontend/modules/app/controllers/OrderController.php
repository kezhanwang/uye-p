<?php
/**
 * Created by PhpStorm.
 * User: wangyi
 * Date: 2017/10/18
 * Time: 下午2:04
 */

namespace app\modules\app\controllers;


use app\modules\app\components\AppController;

class OrderController extends AppController
{
    public function init()
    {
        parent::init(); // TODO: Change the autogenerated stub
    }

    public function actions()
    {
        return [
            'list' => [
                'class' => 'app\modules\app\actions\OrderAction'
            ],
        ];
    }
}
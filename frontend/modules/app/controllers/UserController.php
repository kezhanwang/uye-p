<?php
/**
 * Created by PhpStorm.
 * User: wangyi
 * Date: 2017/10/11
 * Time: 下午3:24
 */

namespace app\modules\app\controllers;


class UserController
{
    public function actions()
    {
        $actions = [
            'index' => [
                'class' => 'app\modules\app\actions\UserinfoAction',
            ],
        ];
        return $actions;
    }
}
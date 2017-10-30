<?php
/**
 * Created by PhpStorm.
 * User: wangyi
 * Date: 2017/10/30
 * Time: 上午11:23
 */

namespace app\modules\app\controllers;


use app\modules\app\components\AppController;
use common\models\ar\UyeUserContact;
use components\Output;
use components\UException;

class ContactController extends AppController
{
    public function init()
    {
        parent::init(); // TODO: Change the autogenerated stub
        $this->checkLogin();
    }

    public function actions()
    {
        $actions = [
            'submit' => [
                'class' => 'app\modules\app\actions\ContactAction',
            ],
        ];
        return $actions;
    }

    public function actionInfo()
    {
        try {
            $userInfo = UyeUserContact::getUserInfo($this->uid);
            Output::info(SUCCESS, SUCCESS_CONTENT, $userInfo);
        } catch (UException $exception) {
            Output::err($exception->getCode(), $exception->getMessage());
        }
    }

    public function actionConfig()
    {
        try {
            $data = [
                'relation' => ['父母', '配偶', '监护人', '子女', '兄弟姐妹', '亲属', '同事', '朋友', '同学', '其他'],
                'marriage' => ['已婚有子女', '已婚无子女', '未婚', '离异', '其他'],
            ];
            Output::info(SUCCESS, SUCCESS_CONTENT, $data);
        } catch (UException $exception) {
            Output::err($exception->getCode(), $exception->getMessage());
        }
    }
}
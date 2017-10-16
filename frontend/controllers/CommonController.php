<?php
/**
 * Created by PhpStorm.
 * User: wangyi
 * Date: 2017/9/20
 * Time: 下午7:45
 */

namespace frontend\controllers;


use components\Output;
use frontend\components\UController;

class CommonController extends UController
{

    public function actionGet400()
    {
        Output::info(SUCCESS, SUCCESS_CONTENT, array('company_phone' => \Yii::$app->params['company_phone']));
    }

    public function actionUpload()
    {
        
    }
}
<?php
/**
 * Created by PhpStorm.
 * User: wangyi
 * Date: 2017/9/20
 * Time: 下午7:45
 */

namespace frontend\controllers;


use common\models\service\SimgService;
use components\Output;
use components\PicUtil;
use components\UException;
use frontend\components\UController;
use frontend\models\DataBus;

class CommonController extends UController
{

    public function actionGet400()
    {
        Output::info(SUCCESS, SUCCESS_CONTENT, array('company_phone' => \Yii::$app->params['company_phone']));
    }

    public function actionUpload()
    {
        try {
            \Yii::info(__LINE__ . ':' . __FUNCTION__ . DataBus::get('uid') . ':' . DataBus::get('plat') . " upload pic :" . var_export($_FILES, true), 'upload_file');
            $ret = PicUtil::uploadPic(PicUtil::SECRET_ADMIN);
            $ret = PicUtil::getUrls($ret, PicUtil::SECRET_ADMIN);
            SimgService::addSimgInfo($ret, DataBus::get('uid'));
            \Yii::info(__LINE__ . ':' . __FUNCTION__ . DataBus::get('uid') . ':' . DataBus::get('plat') . " upload pic return url:" . var_export($ret, true), 'upload_file');
            Output::info(SUCCESS, SUCCESS_CONTENT, $ret);
        } catch (UException $exception) {
            \Yii::error(__LINE__ . ':' . __FUNCTION__ . DataBus::get('uid') . ':' . DataBus::get('plat') . " upload pic error:" . $exception->getMessage(), 'upload_file');
            Output::err($exception->getCode(), $exception->getMessage());
        }
    }
}
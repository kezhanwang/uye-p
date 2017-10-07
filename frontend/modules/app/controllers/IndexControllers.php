<?php
/**
 * Created by PhpStorm.
 * User: wangyi
 * Date: 2017/9/30
 * Time: 下午5:15
 */

namespace app\modules\app\controllers;


use app\modules\app\components\AppController;
use common\models\ar\UyeCategory;
use components\BaiduMap;
use components\Output;
use components\UException;
use frontend\modules\app\models\HomeApi;
use Yii;

class IndexControllers extends AppController
{
    /**
     * 首页接口
     */
    public function actionIndex()
    {
        try {
            //确定用户城市
            $request = Yii::$app->request;
            $lng = $request->get('lng');
            $lat = $request->get('lat');

            $version = $request->get('version');

            $result = HomeApi::$version($request->get());

            $templateData = [
//                'categorys' => $categorys
            ];
        } catch (UException $exception) {
            Output::err($exception->getCode(), $exception->getMessage());
        }
    }

    /**
     * 定位接口
     */
    public function actionocation()
    {

    }
}
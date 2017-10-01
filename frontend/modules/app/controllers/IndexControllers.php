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
use Yii;

class IndexControllers extends AppController
{
    public function actionIndex()
    {
        try {
            //确定用户城市
            $request = Yii::$app->request;
            $lng = $request->get('lng');
            $lat = $request->get('lat');

            $gps = BaiduMap::getPosInfo($lng, $lat);

            //拉取机构分类面包屑
            $categorys = UyeCategory::find()->asArray()->all();

            //获取周边的学校

            $templateData = [
                'categorys' => $categorys
            ];
        } catch (UException $exception) {
            Output::err($exception->getCode(), $exception->getMessage());
        }
    }
}
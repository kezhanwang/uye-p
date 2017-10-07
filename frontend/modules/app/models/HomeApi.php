<?php
/**
 * Created by PhpStorm.
 * User: wangyi
 * Date: 2017/10/7
 * Time: 下午10:18
 */

namespace frontend\modules\app\models;

use common\models\ar\UyeCategory;
use components\BaiduMap;
use components\Output;
use components\UException;
use Yii;

class HomeApi
{
    /**
     * 第一版本接口
     * @param array $params
     * @return array
     */
    public static function v1_0_0($params = array())
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
            return $templateData;
        } catch (UException $exception) {
            Output::err($exception->getCode(), $exception->getMessage());
        }
    }
}
<?php
/**
 * Created by PhpStorm.
 * User: wangyi
 * Date: 2017/10/9
 * Time: 上午11:36
 */

namespace app\modules\app\actions;

use common\models\ar\UyeCategory;
use components\BaiduMap;
use components\UException;
use frontend\models\DataBus;
use Yii;
use app\modules\app\components\AppAction;
use components\Output;

class IndexAction extends AppAction
{

    public function run()
    {
        try {
            //确定用户城市
            $request = Yii::$app->request;
            $lng = $request->get('map_lng');
            $lat = $request->get('map_lat');
            if (empty($lng) || !is_numeric($lng) || empty($lat) || !is_numeric($lat)) {
                throw new UException(ERROR_GPS_LOCATION_CONTENT, ERROR_GPS_LOCATION);
            }
            $gps = BaiduMap::getPosInfo($lng, $lat);

            //拉取机构分类面包屑
            $categorys = UyeCategory::find()->select('id,name,logo')->asArray()->all();


            //获取周边的学校
            $templateData = [
                'loaction' => $gps['addressComponent']['city'],
                'categorys' => $categorys,
            ];
            Output::info(SUCCESS, SUCCESS_CONTENT, $templateData, $this->token());
        } catch (\Exception $exception) {
            Output::err($exception->getCode(), $exception->getMessage(), array(), DataBus::get('uid'), $this->token());
        }
    }
}
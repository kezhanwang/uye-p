<?php
/**
 * Created by PhpStorm.
 * User: wangyi
 * Date: 2017/10/9
 * Time: 上午11:36
 */

namespace app\modules\app\actions;

use common\models\ar\UyeAppLog;
use common\models\ar\UyeCategory;
use components\BaiduMap;
use components\RedisUtil;
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

            $this->createAppLog($request->get('phoneid'), $lng, $lat, $gps);

            //拉取机构分类面包屑
            $categorys = UyeCategory::find()->select('id,name,logo')->asArray()->all();

            $templateData = [
                'loaction' => $gps['addressComponent']['city'],
                'categorys' => $categorys,
            ];
            Output::info(SUCCESS, SUCCESS_CONTENT, $templateData);
        } catch (\Exception $exception) {
            Output::err($exception->getCode(), $exception->getMessage(), array(), DataBus::get('uid'));
        }
    }

    private function createAppLog($phoneid, $lng, $lat, $gps)
    {
        try {
            $data = [
                'phoneid' => $phoneid,
                'uid' => DataBus::get('uid'),
                'map_lng' => $lng,
                'map_lat' => $lat,
                'country' => $gps['addressComponent']['country'],
                'province' => $gps['addressComponent']['province'],
                'city' => $gps['addressComponent']['city'],
                'district' => $gps['addressComponent']['district'],
                'town' => $gps['addressComponent']['town'],
                'street' => $gps['addressComponent']['street'],
                'street_number' => $gps['addressComponent']['street_number'],
                'request_time' => $_SERVER['REQUEST_TIME'],
                'login_time' => $this->isLogin() ? $_SERVER['REQUEST_TIME'] : 0
            ];
            $addLog = UyeAppLog::_addLog($data);
            if (!$this->isLogin()) {
                $redis = RedisUtil::getInstance();
                $sessionID = session_id();
                $redisKey = 'UYE-APP-LOG-' . md5($phoneid . $sessionID);
                $redis->set($redisKey, $addLog['id'], 3600 * 24);

            }
        } catch (\Exception $exception) {
            Yii::error($exception->getMessage());
        }
    }
}
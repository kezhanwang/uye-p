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
use common\models\ar\UyeOrg;
use common\models\ar\UyeOrgWifi;
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
            $lng = $request->isPost ? $request->post('map_lng') : $request->get('map_lng');
            $lat = $request->isPost ? $request->post('map_lat') : $request->get('map_lat');
            $mac = $request->isPost ? $request->post('mac') : $request->get('mac');
            $ssid = $request->isPost ? $request->post('ssid') : $request->get('ssid');

            $ip = ip2long($request->getUserIP());
            if (empty($lng) || !is_numeric($lng) || empty($lat) || !is_numeric($lat)) {
                throw new UException(ERROR_GPS_LOCATION_CONTENT, ERROR_GPS_LOCATION);
            }
            $gps = BaiduMap::getPosInfo($lng, $lat);
            $this->createAppLog($request->get('phoneid'), $lng, $lat, $gps);
            $insuredOrder = $this->getUserInsuredOrder();
            $organize = $this->checkMacAndSSIDwihtIP($mac, $ssid, $ip);

            $adList = [
                [
                    'logo' => 'http://dev.img.bjzhongteng.com/201710/19/guidelines.png',
                    'url' => '',
                ],
                [
                    'logo' => 'http://dev.img.bjzhongteng.com/201710/19/guidelines.png',
                    'url' => '',
                ]
            ];

            $templateData = [
                'loaction' => $gps['addressComponent']['city'],
                'count_order' => '已有1000位学院加入U业帮就业无忧计划',
                'insured_order' => $insuredOrder,
                'organize' => $organize,
                'ad_list' => $adList
            ];
            Output::info(SUCCESS, SUCCESS_CONTENT, $templateData);
        } catch (\Exception $exception) {
            Output::err($exception->getCode(), $exception->getMessage());
        }
    }

    private function createAppLog($phoneid, $lng, $lat, $gps)
    {
        try {
            $sessionID = session_id();
            $data = [
                'phoneid' => $phoneid,
                'session_id' => $sessionID,
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
                $redisKey = 'UYE-APP-LOG-' . md5($phoneid . $sessionID);
                $redis->set($redisKey, $addLog['id'], 3600 * 24);
            }
        } catch (\Exception $exception) {
            Yii::error($exception->getMessage());
        }
    }

    private function getUserInsuredOrder()
    {
        if ($this->isLogin()) {
            $uid = DataBus::get('uid');
            $compensation = 0;
            $count = 0;
            $paid_compensation = 0;
        } else {
            $compensation = 0;
            $count = 0;
            $paid_compensation = 0;
        }
        $orders = [
            'compensation' => $compensation,
            'count' => $count,
            'paid_compensation' => $paid_compensation
        ];
        return $orders;
    }

    private function checkMacAndSSIDwihtIP($mac, $ssid, $ip)
    {
        $info = UyeOrgWifi::getByMacAndSSID($mac, $ssid, $ip);
        if ($info['org_id']) {
            $organize = UyeOrg::find()->select('id As org_id,org_name')->where('id=:org_id', [':org_id' => $info['org_id']])->asArray()->one();
        } else {
            $organize = [];
        }
        return $organize;
    }

}
<?php
/**
 * Created by PhpStorm.
 * User: wangyi
 * Date: 2017/10/9
 * Time: 上午11:36
 */

namespace app\modules\app\actions;

use common\models\ar\UyeAppLog;
use common\models\ar\UyeInsuredOrder;
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
            $lng = $this->getParams('map_lng');
            $lat = $this->getParams('map_lat');
            $mac = $this->getParams('mac');
            $ssid = $this->getParams('ssid');

            //根据GPS定位解析城市，如果没有开启GPS则返回定位失败
            $gps = [];
            if (empty($lng) || !is_numeric($lng) || empty($lat) || !is_numeric($lat)) {
                $loaction = '定位失败';
            } else {
                $gps = BaiduMap::getPosInfo($lng, $lat);
                if ($gps) {
                    $loaction = $gps['addressComponent']['city'];
                } else {
                    $loaction = '定位失败';
                }
            }
            $organize = $this->checkMacAndSSIDwihtIP($mac, $ssid);
            $adList = [
                [
                    'logo' => 'http://img.bjzhongteng.com/201710/19/guidelines.png',
                    'url' => '',
                ],
            ];
            $insuredOrder = $this->getUserInsuredOrder();
            $premium_amount_top = 2000000;

            $templateData = [
                'loaction' => $loaction,
                'count_order' => $this->getCountOrder(),
                'insured_order' => $insuredOrder,
                'organize' => $organize,
                'ad_list' => $adList,
                'premium_amount_top' => $premium_amount_top,
            ];
            $this->createAppLog($this->getParams('phoneid'), $lng, $lat, $gps);
            Output::info(SUCCESS, SUCCESS_CONTENT, $templateData);
        } catch (\Exception $exception) {
            Output::err($exception->getCode(), $exception->getMessage());
        }
    }

    private function createAppLog($phoneid, $lng = '', $lat = '', $gps = [])
    {
        try {
            $sessionID = session_id();
            $ip = Yii::$app->request->getUserIP();
            if (empty($lng) || !is_numeric($lng) || empty($lat) || !is_numeric($lat)) {
                $pos = BaiduMap::getPosByIp($ip, true);
                if (empty($pos)) {
                    $lat = 0;
                    $lng = 0;
                    $gps['addressComponent'] = ['country' => null, 'province' => null, 'city' => null, 'district' => null, 'town' => null, 'street' => null, 'street_number' => null];
                } else {
                    $lng = number_format($pos['content']['point']['x'], 6, '.', '');
                    $lat = number_format($pos['content']['point']['y'], 6, '.', '');
                    $gps['addressComponent'] = $pos['content']['address_detail'];
                }
            }
            $data = [
                'phoneid' => $phoneid,
                'session_id' => $sessionID,
                'uid' => DataBus::get('uid'),
                'ip' => $ip,
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
            $total = UyeInsuredOrder::find()->select("COUNT(id) AS count,SUM(pay_ceiling) AS pay_ceiling,SUM(actual_repay_amount) AS actual_repay_amount")->from(UyeInsuredOrder::TABLE_NAME)->where('uid=:uid', [':uid' => $this->uid])->asArray()->one();
            $compensation = $total['pay_ceiling'];
            $count = $total['count'];
            $paid_compensation = $total['actual_repay_amount'];
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

    private function checkMacAndSSIDwihtIP($mac, $ssid)
    {
        $info = UyeOrgWifi::getByMacAndSSID($mac, $ssid, Yii::$app->request->getUserIP());
        if ($info['org_id']) {
            $organize = UyeOrg::find()->select('id As org_id,org_name')->where('id=:org_id', [':org_id' => $info['org_id']])->asArray()->one();
        } else {
            $organize = [];
        }
        return $organize;
    }

    private function getCountOrder()
    {
        try {
            $main = 2000;
            $count = UyeInsuredOrder::find()->count('id');
            $all = $main + $count;
            $str = '已有' . $all . '位学员加入U业帮就业无忧计划';
            return $str;
        } catch (UException $exception) {
            return '已有' . $main . '位学院加入U业帮就业无忧计划';
        }
    }
}
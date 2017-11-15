<?php
/**
 * Created by PhpStorm.
 * User: wangyi
 * Date: 2017/9/30
 * Time: 下午4:55
 */

namespace components;


class BaiduMap
{
    public static $_instance;
    public static $access_key;
    public static $url_pos_info = 'http://api.map.baidu.com/geocoder/v2/?output=json';


    public static function getInstance()
    {
        if (!(self::$_instance instanceof self)) {
            self::$_instance = new self();
        }

        $config = \Yii::$app->params['baidu_map'];
        if (empty($config)) {
            throw new UException(ERROR_SECRET_CONFIG_NO_EXISTS_CONTENT, ERROR_SECRET_CONFIG_NO_EXISTS);
        }
        self::$access_key = $config['access_key'];
        return self::$_instance;
    }

    public static function getPosInfo($lng, $lat)
    {
        try {
            self::getInstance();
            $url = self::$url_pos_info . "&ak=" . self::$access_key . "&location={$lat},{$lng}";
            $res = HttpUtil::doGet($url);
            $res = json_decode($res, true);
            if (!isset($res['status']) || $res['status'] != 0 || !isset($res['result'])) {
                throw new UException(ERROR_GPS_LOCATION_CONTENT, ERROR_GPS_LOCATION);
            }
            $ret = $res['result'];
            return $ret;
        } catch (UException $exception) {
            \Yii::error($exception->getMessage());
        }
    }

    public static function getPosByIp($ip, $returnOriginal = false)
    {
        if (is_numeric($ip)) {
            $ip = long2ip($ip);
        }
        if ($ip == '127.0.0.1') {
            return null;
        }
        self::getInstance();
        $url = 'http://api.map.baidu.com/location/ip?' . "ak=" . self::$access_key . "&ip={$ip}&coor=gcj02";
        $res = HttpUtil::doGet($url);

        $res = json_decode($res, true);
        if (!isset($res['status']) || $res['status'] != 0 || !isset($res['content'])) {
            return null;
        }
        if (array_key_exists('point', $res['content'])) {
            if (!$returnOriginal) {
                return array('lng' => $res['content']['point']['x'], 'lat' => $res['content']['point']['y'],);
            } else {
                return $res;
            }
        } else {
            return null;
        }
    }

}
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
            throw new UException();
        }
        self::$access_key = $config['access_key'];
        return self::$_instance;
    }

    public static function getPosInfo($lng, $lat)
    {
        try {
            $url = self::$url_pos_info . "&ak=" . self::$access_key . "&location={$lat},{$lng}";
            $res = HttpUtil::doGet($url);
            $res = json_decode($res, true);
            if (!isset($res['status']) || $res['status'] != 0 || !isset($res['result'])) {
                throw new UException("获取地图信息错误");
            }
            $ret = $res['result'];
            return $ret;
        } catch (UException $exception) {
            \Yii::error($exception->getMessage());
        }
    }
}
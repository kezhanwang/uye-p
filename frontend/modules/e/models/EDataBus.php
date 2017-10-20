<?php
/**
 * Created by PhpStorm.
 * User: wangyi
 * Date: 2017/10/19
 * Time: 下午5:08
 */

namespace app\modules\e\models;

use common\models\ar\UyeEUser;
use components\CookieUtil;
use Yii;

class EDataBus
{
    private static $data = [];
    const COOKIE_KEY = "uye_e_user";

    private static function init()
    {
        self::$data['request'] = $_REQUEST;
        self::$data['request_time'] = $_SERVER['REQUEST_TIME'];
        self::$data['request_time_float'] = $_SERVER['REQUEST_TIME_FLOAT'];
        self::$data['ip_address'] = Yii::$app->request->userIP;
        self::$data['cookie'] = $_COOKIE;
        self::$data['session'] = $_SESSION;

        $checkCookie = self::checkCookie();
        self::$data['uid'] = $checkCookie['uid'];
        self::$data['phone'] = $checkCookie['phone'];
        self::$data['username'] = $checkCookie['username'];
        self::$data['user'] = self::getUserInfo();
        self::$data['isLogin'] = self::checkIsLogin();

        Yii::info('[' . __CLASS__ . '][' . __FUNCTION__ . '][' . __LINE__ . ']: DATABUS INFO:' . var_export(self::$data, true), 'databus');
    }

    public static function get($key)
    {
        if (empty(self::$data)) {
            self::init();
        }

        if (array_key_exists($key, self::$data)) {
            return self::$data[$key];
        } else {
            return self::$data;
        }
    }

    public static function set($key, $value)
    {
        self::$data[$key] = $value;
    }

    private static function checkCookie()
    {
        $cookieValue = CookieUtil::getCookie(self::COOKIE_KEY);
        if (empty($cookieValue)) {
            return ['uid' => 0, 'phone' => '', 'username' => ''];
        }

        $userInfo = CookieUtil::strCode($cookieValue, 'DECODE');
        list($uid, $username, $phone, $safecv) = explode('|', $userInfo);
        return ['uid' => $uid, 'phone' => $phone, 'username' => $username];
    }

    private static function getUserInfo()
    {
        $uid = self::$data['uid'];
        if ($uid < 1) {
            return false;
        }

        $userInfo = UyeEUser::getUserByUid($uid);
        return $userInfo;
    }

    private static function checkIsLogin()
    {
        if (empty(self::$data)) {
            self::init();
        }
        $uid = self::$data['uid'];
        if (empty($uid) || $uid == 0) {
            return false;
        } else {
            return true;
        }
    }
}
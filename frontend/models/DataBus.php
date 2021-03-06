<?php
/**
 * Created by PhpStorm.
 * User: wangyi
 * Date: 2017/9/14
 * Time: 下午7:12
 */

namespace frontend\models;


use common\models\ar\UyeUser;
use components\CookieUtil;
use components\TokenUtil;
use Yii;

require_once PATH_BASE . DIRECTORY_SEPARATOR . ".." . DIRECTORY_SEPARATOR . "vendor" . DIRECTORY_SEPARATOR . "autoload.php";

class DataBus
{

    private static $data = array();
    const COOKIE_KEY = 'uye_user';

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

        $detect = new \Mobile_Detect();
        if ($detect->isMobile()) {
            if ($detect->is('IOS')) {
                $plat = 1;
            } else {
                if ($detect->is('AndroidOS')) {
                    $plat = 2;
                } else {
                    $plat = 3;
                }
            }
        } else {
            $plat = 0;
        }
        self::$data['plat'] = $plat;
        Yii::info('[' . __CLASS__ . '][' . __FUNCTION__ . '][' . __LINE__ . ']: DATABUS INFO:' . var_export(self::$data,
                true), 'databus');
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
        $cookieValue = str_replace(' ', '+', $cookieValue);
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

        $userInfo = UyeUser::getUserByUid($uid);
        return $userInfo->getAttributes();
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

    public static function getToken()
    {
        if (empty(self::$data)) {
            self::init();
        }

        if (self::$data['plat']) {
            $isMobile = true;
        } else {
            $isMobile = false;
        }

        $request = Yii::$app->request;
        $phoneID = $request->isPost ? $request->post('phoneid') : $request->get('phoneid');
        if ($phoneID) {
            $key = $phoneID;
        } else {
            $key = session_id();
        }

        $newToken = TokenUtil::refreshToken($key, self::$data['uid'], $isMobile);
        return $newToken;
    }

}
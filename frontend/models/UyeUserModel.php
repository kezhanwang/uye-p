<?php
/**
 * Created by PhpStorm.
 * User: wangyi
 * Date: 2017/9/18
 * Time: 上午10:36
 */

namespace frontend\models;


use common\models\ar\UyeUser;
use components\CookieUtil;
use components\UException;

class UyeUserModel
{

    /**
     * 注册
     * @param null $phone
     * @param null $password
     * @throws UException
     */
    public static function register($phone = null, $password = null)
    {
        if (is_null($phone) || is_null($password)) {
            throw new UException(ERROR_SYS_PARAMS_CONTENT, ERROR_SYS_PARAMS);
        }

        $checkUser = UyeUser::getUserByPhone($phone);
        if (empty($checkUser)) {
            $inster = [
                'username' => substr($phone, 0, 3) . '****' . substr($phone, 0, -4),
                'password' => self::createPasswordMd5($password),
                'phone' => $phone,
                'status' => 1,
                'created_time' => DataBus::get('request_time'),
                'updated_time' => DataBus::get('request_time'),
            ];
            UyeUser::_addUser($inster);
        } else {
            throw new UException(ERROR_REGISTER_PHONE_REPEAT_CONTENT, ERROR_REGISTER_PHONE_REPEAT);
        }
    }

    /**
     * @param null $phone
     * @param null $password
     * @throws UException
     */
    public static function login($phone = null, $password = null)
    {
        if (is_null($phone) || is_null($password)) {
            throw new UException(ERROR_SYS_PARAMS_CONTENT, ERROR_SYS_PARAMS);
        }
        $passwordMd5 = self::createPasswordMd5($password);
        $userInfo = UyeUser::getUserByLogin($phone, $passwordMd5);
        if (empty($userInfo)) {
            throw new UException(ERROR_LOGIN_NO_USERINFO_CONTENT, ERROR_LOGIN_NO_USERINFO);
        } else {
            $strCode = $userInfo['uid'] . "|" . $userInfo['username'] . "|" . $userInfo['phone'] . '|' . CookieUtil::createSafecv();
            CookieUtil::Cookie(DataBus::COOKIE_KEY, CookieUtil::strCode($strCode), strtotime('+1 month'));
        }
    }

    public static function createPasswordMd5($password)
    {
        return md5($password . USER_PASSWORD_STR);
    }
}
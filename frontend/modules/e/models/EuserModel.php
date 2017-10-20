<?php
/**
 * Created by PhpStorm.
 * User: wangyi
 * Date: 2017/10/19
 * Time: 下午5:23
 */

namespace app\modules\e\models;


use common\models\ar\UyeEUser;
use components\CheckUtil;
use components\UException;

class EuserModel
{
    public static function login($phone, $password)
    {
        if (is_null($phone) || is_null($password) || !CheckUtil::phone($phone) || !CheckUtil::isPWD($password)) {
            throw new UException(ERROR_SYS_PARAMS_CONTENT, ERROR_SYS_PARAMS);
        }

        $passwordMd5 = self::createPasswordMd5($password);
        $userInfo = UyeEUser::getUserByLogin($phone, $passwordMd5);

        if (empty($userInfo)) {
            throw new UException(ERROR_LOGIN_NO_USERINFO_CONTENT, ERROR_LOGIN_NO_USERINFO);
        } else {
            unset($userInfo['password']);
            return $userInfo;
        }
    }

    public static function createPasswordMd5($password)
    {
        return md5($password . USER_PASSWORD_STR);
    }
}
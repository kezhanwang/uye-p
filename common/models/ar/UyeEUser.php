<?php
/**
 * Created by PhpStorm.
 * User: wangyi
 * Date: 2017/10/19
 * Time: 下午5:11
 */

namespace common\models\ar;


use components\UException;

class UyeEUser extends UActiveRecord
{
    const TABLE_NAME = 'uye_e_user';
    const STATUS_NORMAL = 1;
    const STATUS_CLOSE = 2;
    const STATUS_BLACKLIST = 3;

    public static function tableName()
    {
        return self::TABLE_NAME;
    }

    /**
     * @param $uid
     * @return array
     * @throws UException
     */
    public static function getUserByUid($uid)
    {
        if (is_null($uid) || !is_numeric($uid)) {
            throw new UException(ERROR_SYS_PARAMS_CONTENT, ERROR_SYS_PARAMS);
        }

        $userInfo = static::findOne(['uid' => $uid])->getAttributes();
        return $userInfo;
    }

    /**
     * @param null $phone
     * @param null $password
     * @return array|null|\yii\db\ActiveRecord
     * @throws UException
     */
    public static function getUserByLogin($phone = null, $password = null)
    {
        if (is_null($phone) || is_null($password)) {
            throw new UException(ERROR_SYS_PARAMS_CONTENT, ERROR_SYS_PARAMS);
        }

        $userInfo = self::find()->select('*')
            ->where('phone=:phone AND password=:password AND status=:status', [':phone' => $phone, ':password' => $password, ':status' => self::STATUS_NORMAL])
            ->asArray()
            ->one();
        if ($userInfo) {
            return $userInfo;
        } else {
            return array();
        }
    }
}
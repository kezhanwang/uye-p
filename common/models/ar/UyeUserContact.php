<?php
/**
 * Created by PhpStorm.
 * User: wangyi
 * Date: 2017/10/30
 * Time: 上午11:22
 */

namespace common\models\ar;


use components\ArrayUtil;
use components\UException;

class UyeUserContact extends UActiveRecord
{
    const TABLE_NAME = 'uye_user_contact';

    public static function tableName()
    {
        return self::TABLE_NAME;
    }

    public static function getUserInfo($uid)
    {
        $userInfo = self::find()
            ->select('*')
            ->from(self::TABLE_NAME)
            ->where('uid=:uid', [':uid' => $uid])
            ->asArray()
            ->one();

        if (empty($userInfo)) {
            return [];
        } else {
            return $userInfo;
        }
    }

    public static function _add($info = [])
    {
        if (empty($info)) {
            return false;
        }

        $info = ArrayUtil::trimArray($info);

        $ar = new UyeUserContact();
        foreach ($ar->getAttributes() as $key => $attribute) {
            if (array_key_exists($key, $info)) {
                $ar->$key = $info[$key];
            }
        }

        $ar->created_time = time();
        $ar->updated_time = time();

        if (!$ar->save()) {
            UException::dealAR($ar);
        }

        return $ar->getAttributes();
    }

    public static function _update($uid, $info)
    {
        if (empty($uid) || !is_numeric($uid) || empty($info)) {
            return false;
        }

        $ar = self::findOne($uid);

        foreach ($ar->getAttributes() as $key => $attribute) {
            if (array_key_exists($key, $info)) {
                $ar->$key = $info[$key];
            }
        }

        $ar->updated_time = time();
        if (!$ar->save()) {
            UException::dealAR($ar);
        }

        return $ar->getAttributes();
    }
}
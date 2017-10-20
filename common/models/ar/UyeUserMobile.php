<?php
/**
 * Created by PhpStorm.
 * User: wangyi
 * Date: 2017/10/13
 * Time: 下午4:55
 */

namespace common\models\ar;


use components\UException;

class UyeUserMobile extends UActiveRecord
{
    const TABLE_NAME = 'uye_user_mobile';

    public static function tableName()
    {
        return self::TABLE_NAME;
    }

    public static function _add($info)
    {
        if (empty($info)) {
            return false;
        }

        $ar = new UyeUserMobile();
        $ar->setIsNewRecord(true);
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

        $ar = self::findOne('uid=' . $uid);
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
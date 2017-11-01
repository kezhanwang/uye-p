<?php
/**
 * Created by PhpStorm.
 * User: wangyi
 * Date: 2017/10/30
 * Time: 下午3:54
 */

namespace common\models\ar;


use components\ArrayUtil;
use components\UException;

class UyeUserExperience extends UActiveRecord
{
    const TABLE_NAME = 'uye_user_experience';

    public static function tableName()
    {
        return self::TABLE_NAME;
    }

    public static function getByUid($uid)
    {
        $info = self::find()
            ->select('*')
            ->from(self::TABLE_NAME)
            ->where('uid=:uid', [':uid' => $uid])
            ->asArray()->one();
        if (empty($info)) {
            return [];
        } else {
            return $info;
        }
    }

    public static function _add($info = [])
    {
        if (empty($info)) {
            return [];
        }

        $ar = new UyeUserExperience();
        $info = ArrayUtil::trimArray($info);
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

    public static function _update($uid, $info = [])
    {
        if (empty($uid) || !is_numeric($uid) || empty($info)) {
            return false;
        }

        $ar = self::findOne($uid);
        $info = ArrayUtil::trimArray($info);
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
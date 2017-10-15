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

    public static function _update($uid, $info)
    {
        if (empty($uid) || !is_numeric($uid) || empty($info)) {
            return false;
        }

        $ar = self::findOne('uid=' . $uid);
        if (empty($ar)) {
            $ar = new UyeUserMobile();
            $ar->setIsNewRecord(true);
            $ar->uid = $uid;
            $ar->created_time = time();
        }

        foreach ($ar->getAttributes() as $key => $attribute) {
            if (!array_key_exists($key, $info)) {
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
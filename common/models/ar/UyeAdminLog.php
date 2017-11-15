<?php
/**
 * Created by PhpStorm.
 * User: wangyi
 * Date: 2017/11/15
 * Time: 上午10:27
 */

namespace common\models\ar;


use components\ArrayUtil;
use components\UException;

class UyeAdminLog extends UActiveRecord
{
    const TABLE_NAME = 'uye_admin_log';

    public static function tableName()
    {
        return self::TABLE_NAME;
    }

    public static function _add($info = array())
    {
        if (empty($info)) {
            return [];
        }

        $info = ArrayUtil::trimArray($info);
        $ar = new UyeAdminLog();
        foreach ($ar->getAttributes() as $key => $attribute) {
            if (array_key_exists($key, $info)) {
                $ar->$key = $info[$key];
            }
        }

        if (!$ar->save()) {
            UException::dealAR($ar);
        }

        return $ar->getAttributes();
    }
}
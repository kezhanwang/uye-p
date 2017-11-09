<?php
/**
 * Created by PhpStorm.
 * User: wangyi
 * Date: 2017/11/9
 * Time: 下午3:04
 */

namespace common\models\ar;


use components\ArrayUtil;
use components\UException;

class UyeDownloadLog extends UActiveRecord
{
    const TABLE_NAME = 'uye_download_log';

    public static function tableName()
    {
        return self::TABLE_NAME;
    }

    public static function _add($info)
    {
        if (empty($info)) {
            return false;
        }

        $info = ArrayUtil::trimArray($info);

        $ar = new UyeDownloadLog();
        $ar->setIsNewRecord(true);

        foreach ($ar->getAttributes() as $key => $attribute) {
            if (array_key_exists($key, $info)) {
                $ar->$key = $info[$key];
            }
        }
        $ar->created_time = time();
        if (!$ar->save()) {
            UException::dealAR($ar);
        }
        return $ar->getAttributes();
    }
}
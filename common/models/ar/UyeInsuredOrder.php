<?php
/**
 * Created by PhpStorm.
 * User: wangyi
 * Date: 2017/10/17
 * Time: 上午11:13
 */

namespace common\models\ar;


use components\ArrayUtil;
use components\UException;

class UyeInsuredOrder extends UActiveRecord
{
    const TABLE_NAME = 'uye_insured_order';

    const INSURED_TYPE_EMPLOYMENT = 1;
    const INSURED_TYPE_SALARY = 2;

    public static function tableName()
    {
        return self::TABLE_NAME;
    }

    public static function _add($info = array())
    {
        if (empty($info)) {
            return false;
        }
        $ar = new UyeInsuredOrder();
        $ar->setIsNewRecord(true);

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
}
<?php
/**
 * Created by PhpStorm.
 * User: wangyi
 * Date: 2017/11/16
 * Time: 上午11:51
 */

namespace common\models\ar;


use components\ArrayUtil;
use components\UException;

class UyeInsuredWork extends UActiveRecord
{
    const  TABLE_NAME = 'uye_insured_work';

    const IS_HIRING_SUCCESS = 1;
    const IS_HIRING_WAIT = 2;

    public static $hiring = [
        self::IS_HIRING_SUCCESS => '已录用',
        self::IS_HIRING_WAIT => '待定'
    ];

    public static function tableName()
    {
        return self::TABLE_NAME;
    }

    public static function _add($info = array())
    {
        if (empty($info)) {
            return false;
        }

        $info = ArrayUtil::trimArray($info);
        $ar = new UyeInsuredWork();
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

    public static function getListByInsuredID($insured_id)
    {
        if (empty($insured_id) || !is_numeric($insured_id)) {
            return [];
        }

        $list = static::find()
            ->select('*')
            ->from(self::TABLE_NAME)
            ->where('insured_id=:insured_id', [':insured_id' => $insured_id])
            ->asArray()->one();
        if (empty($list)) {
            return [];
        } else {
            return $list;
        }
    }
}
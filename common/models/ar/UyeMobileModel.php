<?php
/**
 * Created by PhpStorm.
 * User: wangyi
 * Date: 2017/10/19
 * Time: 下午2:50
 */

namespace common\models\ar;


use components\ArrayUtil;
use components\UException;

class UyeMobileModel extends UActiveRecord
{
    const TABLE_NAME = 'uye_mobile_model';

    public static function tableName()
    {
        return self::TABLE_NAME;
    }

    public static function getByUniqueID($unique_id)
    {
        if (empty($unique_id)) {
            return [];
        }

        $result = self::find()
            ->select('*')
            ->from(self::TABLE_NAME)
            ->where('unique_id=:unique_id', [':unique_id' => $unique_id])
            ->asArray()
            ->all();

        return $result;
    }

    public static function _add($uniqud_id, $fileData)
    {
        if (empty($fileData)) {
            return false;
        }

        $ar = self::findOne("unique_id='{$uniqud_id}'");

        if (empty($ar)) {
            $ar = new UyeMobileModel();
            $ar->setIsNewRecord(true);
            $info = ArrayUtil::trimArray($fileData);
            foreach ($ar->getAttributes() as $key => $attribute) {
                if (array_key_exists($key, $info)) {
                    $ar->$key = $info[$key];
                }
            }

            if (!$ar->save()) {
                UException::dealAR($ar);
            }
        }
        return $ar->getAttributes();
    }
}
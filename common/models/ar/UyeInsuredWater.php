<?php
/**
 * Created by PhpStorm.
 * User: wangyi
 * Date: 2017/10/24
 * Time: 下午5:55
 */

namespace common\models\ar;

use components\ArrayUtil;
use components\UException;

/**
 * This is the model class for table "uye_insured_water".
 *
 * @property integer $id
 * @property integer $uid
 * @property integer $user_type
 * @property integer $insured_id
 * @property string $pay_amount
 * @property integer $pay_source
 * @property integer $pay_status
 * @property integer $created_time
 */
class UyeInsuredWater extends UActiveRecord
{
    const TABLE_NAME = 'uye_insured_water';

    const USER_TYPE_ORG = 1;
    const USER_TYPE_USER = 2;

    const PAY_STATUS_SUCCESS = 1;
    const PAY_STATUS_FAILE = 2;

    const PAY_SOURCE_OFFLINE = 1;
    const PAY_SOURCE_BAOFU = 2;

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

        $ar = new UyeInsuredWater();
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
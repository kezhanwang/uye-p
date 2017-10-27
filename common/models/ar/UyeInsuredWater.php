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

    public static $userType = [
        self::USER_TYPE_ORG => '机构',
        self::USER_TYPE_USER => '用户'
    ];

    const PAY_STATUS_SUCCESS = 1;
    const PAY_STATUS_FAIL = 2;

    public static $payStatus = [
        self::PAY_STATUS_SUCCESS => '支付成功',
        self::PAY_STATUS_FAIL => '支付失败'
    ];

    const PAY_SOURCE_OFFLINE = 1;
    const PAY_SOURCE_BAOFU = 2;

    public static $paySource = [
        self::PAY_SOURCE_OFFLINE => '线下支付',
        self::PAY_SOURCE_BAOFU => '宝付支付',
    ];

    const ACCOUNTING_STATUS_YES = 1;
    const ACCOUNTING_STATUS_NO = 2;
    public static $status = [
        self::ACCOUNTING_STATUS_YES => '已核算',
        self::ACCOUNTING_STATUS_NO => '未核算'
    ];

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
        $ar->updated_time = time();
        if (!$ar->save()) {
            UException::dealAR($ar);
        }

        return $ar->getAttributes();
    }

    public static function _update($id, $info)
    {
        if (empty($id) || !is_numeric($id)) {
            return false;
        }

        if (empty($info)) {
            return false;
        }

        $info = ArrayUtil::trimArray($info);

        $ar = self::findOne($id);
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
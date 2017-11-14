<?php
/**
 * Created by PhpStorm.
 * User: wangyi
 * Date: 2017/10/12
 * Time: 下午4:29
 */

namespace common\models\ar;

use components\ArrayUtil;
use components\UException;

/**
 * This is the model class for table "uye_user_auth".
 *
 * @property integer $id
 * @property integer $uid
 * @property string $order
 * @property string $no_product
 * @property integer $result_auth
 * @property double $be_idcard
 * @property string $fail_reason
 * @property string $id_card
 * @property string $id_name
 * @property string $nation
 * @property integer $sex
 * @property string $birthday
 * @property integer $age
 * @property string $address
 * @property string $issuing_authority
 * @property string $idcard_start
 * @property string $idcard_expired
 * @property string $front_card
 * @property string $back_card
 * @property string $photo_get
 * @property string $photo_grid
 * @property string $photo_living
 * @property string $info_order
 * @property string $user_profiles
 * @property string $user_report
 * @property integer $created_time
 * @property integer $updated_time
 */
class UyeUserAuth extends UActiveRecord
{
    const TABLE_NAME = 'uye_user_auth';

    /**
     * 认证结果
     */
    const RESULT_AUTH_FALSE = 1;    //认真不通过
    const RESULT_AUTH_TRUE = 2; //认证通过
    /**
     * 性别
     */
    const SEX_MALE = 1;     //男
    const SEX_FEMALE = 2;   //女

    const USER_ID_SUFFIX = 'KZP_';
    const REDIS_KEY = 'KZ_PAY_UDCREDIT_';

    const SAFE_MODE_HIGH = 0;
    const SAFE_MODE_MIDDLE = 1;
    const SAFE_MODE_LOW = 2;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return self::TABLE_NAME;
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'uid' => 'Uid',
            'order' => 'Order',
            'no_product' => 'No Product',
            'result_auth' => 'Result Auth',
            'be_idcard' => 'Be Idcard',
            'fail_reason' => 'Fail Reason',
            'id_card' => 'Id Card',
            'id_name' => 'Id Name',
            'nation' => 'Nation',
            'sex' => 'Sex',
            'birthday' => 'Birthday',
            'age' => 'Age',
            'address' => 'Address',
            'issuing_authority' => 'Issuing Authority',
            'idcard_start' => 'Idcard Start',
            'idcard_expired' => 'Idcard Expired',
            'front_card' => 'Front Card',
            'back_card' => 'Back Card',
            'photo_get' => 'Photo Get',
            'photo_grid' => 'Photo Grid',
            'photo_living' => 'Photo Living',
            'info_order' => 'Info Order',
            'user_profiles' => 'User Profiles',
            'user_report' => 'User Report',
        ];
    }

    public static function _add($info)
    {
        if (empty($info)) {
            throw new UException(ERROR_SYS_PARAMS_CONTENT, ERROR_SYS_PARAMS);
        }

        $ar = new UyeUserAuth();
        $ar->setIsNewRecord(true);
        $attributes = $ar->getAttributes();
        $info = ArrayUtil::trimArray($info);
        foreach ($attributes as $key => $attribute) {
            if (array_key_exists($key, $info)) {
                $ar->$key = $info[$key];
            }
        }

        $ar->created_time = time();
        $ar->updated_time = time();

        if (!$ar->save()) {
            throw new UException(var_export($ar->getErrors(), true), ERROR_DB);
        }
        return $ar->getAttributes();
    }

    public static function _updateByOrder($order, $info)
    {
        if (empty($order) || empty($info)) {
            throw new UException(ERROR_SYS_PARAMS_CONTENT, ERROR_SYS_PARAMS);
        }

        $ar = static::findOne(['order' => $order]);
        $attributes = $ar->getAttributes();
        $info = ArrayUtil::trimArray($info);
        foreach ($attributes as $key => $attribute) {
            if (!empty($info[$key])) {
                $ar->$key = $info[$key];
            }
        }

        $ar->updated_time = time();

        if (!$ar->save()) {
            throw new UException(var_export($ar->getErrors(), true), ERROR_DB);
        }
        return $ar->getAttributes();
    }

    public static function getUserInfoByOrder($order)
    {
        if (empty($order)) {
            return [];
        }

        $userInfo = self::find()
            ->select('*')
            ->from(self::TABLE_NAME)
            ->where('`order`=:order', [':order' => $order])
            ->asArray()
            ->one();
        if (empty($userInfo)) {
            return [];
        } else {
            return $userInfo;
        }
    }
}
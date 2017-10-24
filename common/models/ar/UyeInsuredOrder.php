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

/**
 * This is the model class for table "uye_insured_order".
 *
 * @property integer $id
 * @property string $insured_order
 * @property integer $insured_status
 * @property integer $insured_type
 * @property integer $uid
 * @property integer $org_id
 * @property integer $c_id
 * @property string $tuition
 * @property string $premium_amount
 * @property integer $payment_method
 * @property string $pay_ceiling
 * @property string $actual_repay_amount
 * @property string $class
 * @property string $class_start
 * @property string $class_end
 * @property string $course_consultant
 * @property string $group_pic
 * @property string $training_pic
 * @property string $phoneid
 * @property double $map_lng
 * @property double $map_lat
 * @property integer $created_time
 * @property integer $updated_time
 */
class UyeInsuredOrder extends UActiveRecord
{
    const TABLE_NAME = 'uye_insured_order';

    const INSURED_TYPE_EMPLOYMENT = 1;
    const INSURED_TYPE_SALARY = 2;

    public static $insuredType = [
        self::INSURED_TYPE_EMPLOYMENT => '就业帮',
        self::INSURED_TYPE_SALARY => '高薪帮',
    ];

    const PAYMENT_METHOD_ORG = 1;
    const PAYMENT_METHOD_USER = 2;
    public static $paymentMethod = [
        self::PAYMENT_METHOD_ORG => '机构付款',
        self::PAYMENT_METHOD_USER => '学员付款',
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

    public static function _update($id, $info = [])
    {
        if (empty($id) || empty($info)) {
            return false;
        }
        $ar = self::findOne($id);
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

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'insured_order' => '保单号',
            'insured_status' => '保单状态',
            'insured_type' => '保单类型',
            'uid' => '用户',
            'org_id' => '机构',
            'c_id' => '课程',
            'tuition' => '学费',
            'premium_amount' => '保费金额',
            'payment_method' => 'Payment Method',
            'pay_ceiling' => 'Pay Ceiling',
            'actual_repay_amount' => 'Actual Repay Amount',
            'class' => 'Class',
            'class_start' => 'Class Start',
            'class_end' => 'Class End',
            'course_consultant' => 'Course Consultant',
            'group_pic' => 'Group Pic',
            'training_pic' => 'Training Pic',
            'phoneid' => 'Phoneid',
            'map_lng' => 'Map Lng',
            'map_lat' => 'Map Lat',
            'created_time' => '创建时间',
            'updated_time' => '更新时间',
        ];
    }

    public static function createInsuredOrder($uid)
    {
        $order_id_main = date('YmdHis') . rand(10000, 99999);
        $order_id_len = strlen($order_id_main);
        $order_id_sum = 0;
        for ($i = 0; $i < $order_id_len; $i++) {
            $order_id_sum += (int)(substr($order_id_main, $i, 1));
        }
        $order_id = $order_id_main . str_pad((100 - $order_id_sum % 100) % 100, 2, '0', STR_PAD_LEFT);
        return $order_id;
    }

    public static function getInsuredStatusDesp($status = '')
    {
        $insuredStatus = [
            INSURED_STATUS_CREATE => INSURED_STATUS_CREATE_CONTENT,
            INSURED_STATUS_VERIFY_PASS => INSURED_STATUS_VERIFY_PASS_CONTENT,
            INSURED_STATUS_VERIFY_REFUSE => INSURED_STATUS_VERIFY_REFUSE_CONTENT,
            INSURED_STATUS_PAYMENT => INSURED_STATUS_PAYMENT_CONTENT,
            INSURED_STATUS_STUDYING => INSURED_STATUS_STUDYING_CONTENT
        ];

        if (isset($insuredStatus[$status])) {
            return $insuredStatus[$status];
        } else {
            return $insuredStatus;
        }
    }

    public function getOrg()
    {
        return $this->hasOne(UyeOrg::className(), ['id' => 'org_id']);
    }

    public function getIdentity()
    {
        return $this->hasOne(UyeUserIdentity::className(), ['uid' => 'uid']);
    }
}
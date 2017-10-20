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

    public static function tableName()
    {
        return self::TABLE_NAME;
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['insured_order', 'uid', 'org_id', 'c_id', 'premium_amount', 'pay_ceiling', 'class', 'class_start', 'class_end', 'course_consultant', 'group_pic', 'training_pic'], 'required'],
            [['insured_status', 'insured_type', 'uid', 'org_id', 'c_id', 'payment_method', 'created_time', 'updated_time'], 'integer'],
            [['tuition', 'premium_amount', 'pay_ceiling', 'actual_repay_amount', 'map_lng', 'map_lat'], 'number'],
            [['class_start', 'class_end'], 'safe'],
            [['training_pic'], 'string'],
            [['insured_order'], 'string', 'max' => 41],
            [['class', 'course_consultant'], 'string', 'max' => 30],
            [['group_pic'], 'string', 'max' => 500],
            [['phoneid'], 'string', 'max' => 60],
        ];
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
            'premium_amount' => 'Premium Amount',
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
}
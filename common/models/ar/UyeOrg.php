<?php
/**
 * Created by PhpStorm.
 * User: wangyi
 * Date: 2017/9/23
 * Time: 上午9:21
 */

namespace common\models\ar;

use components\ArrayUtil;
use components\UException;

/**
 * This is the model class for table "uye_org".
 *
 * @property integer $id
 * @property string $org_short_name
 * @property string $org_name
 * @property integer $org_type
 * @property integer $parent_id
 * @property integer $status
 * @property integer $is_shelf
 * @property integer $is_delete
 * @property integer $is_employment
 * @property integer $is_high_salary
 * @property integer $created_time
 * @property integer $updated_time
 */
class UyeOrg extends UActiveRecord
{
    const TABLE_NAME = 'uye_org';


    const STATUS_SAVE = 1;
    const STATUS_NO_AUDITED = 2;
    const STATUS_NO_PASS = 3;
    const STATUS_OK = 4;
    public static $orgStatus = [
        self::STATUS_SAVE => '保存',
        self::STATUS_NO_AUDITED => '未审核',
        self::STATUS_NO_PASS => '审核未通过',
        self::STATUS_OK => '审核通过',
    ];


    const IS_SHELF_ON = 1;
    const IS_SHELF_OFF = 2;
    public static $isShelf = [
        self::IS_SHELF_ON => '上架',
        self::IS_SHELF_OFF => '下架'
    ];

    const ORG_TYPE_GENERAL = 1;
    const ORG_TYPE_BRANCH = 2;
    const ORG_TYPE_FRANCHISE = 3;
    public static $orgType = [
        self::ORG_TYPE_GENERAL => '总校',
        self::ORG_TYPE_BRANCH => '分校',
        self::ORG_TYPE_FRANCHISE => '加盟',
    ];

    const IS_EMPLOYMENT_SUPPORT = 1;
    const IS_EMPLOYMENT_NOT_SUPPORT = 2;

    public static $isEmployment = [
        self::IS_EMPLOYMENT_SUPPORT => '支持',
        self::IS_EMPLOYMENT_NOT_SUPPORT => '不支持',
    ];

    const IS_HIGH_SALARY_SUPPORT = 1;
    const IS_HIGH_SALARY_NOT_SUPPORT = 2;
    public static $isHighSalary = [
        self::IS_HIGH_SALARY_SUPPORT => '支持',
        self::IS_HIGH_SALARY_NOT_SUPPORT => '不支持',
    ];

    const IS_DELETE_ON = 1;
    const IS_DELETE = 2;
    public static $isDelete = [
        self::IS_DELETE_ON => '正常',
        self::IS_DELETE => '已删除'
    ];


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
            'org_short_name' => '简称',
            'org_name' => '机构',
            'org_type' => '类型',
            'parent_id' => '总校',
            'status' => '状态',
            'is_shelf' => '上下架',
            'is_delete' => '是否删除',
            'is_employment' => '就业帮',
            'is_high_salary' => '高薪帮',
            'created_time' => '创建时间',
            'updated_time' => '更新时间',
        ];
    }

    public static function getOrgById($id)
    {
        if (empty($id) || !is_numeric($id)) {
            return false;
        }

        $org = self::find()
            ->select('*')
            ->from(self::TABLE_NAME)
            ->where('id=:id AND status=:status AND is_shelf=:is_shelf ', [':id' => $id, ':status' => self::STATUS_OK, ':is_shelf' => self::IS_SHELF_ON])
            ->asArray()
            ->one();
        if (empty($org)) {
            return [];
        } else {
            return $org;
        }
    }

    public static function _update($id, $info)
    {
        if (empty($id) || empty($info)) {
            return false;
        }
        $ar = static::findOne($id);
        $info = ArrayUtil::trimArray($info);
        foreach ($ar->getAttributes() as $key => $attribute) {
            if (array_key_exists($key, $info)) {
                $ar->$key = $info[$key];
            }
        }

        $ar->updated_time = time();
        if (!$ar->save()) {
            throw new UException($ar);
        }
        return $ar->getAttributes();
    }
}
<?php
/**
 * Created by PhpStorm.
 * User: wangyi
 * Date: 2017/9/23
 * Time: 上午9:21
 */

namespace common\models\ar;

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
        self::IS_EMPLOYMENT_SUPPORT => '支持就业帮',
        self::IS_EMPLOYMENT_NOT_SUPPORT => '不支持就业帮',
    ];

    const IS_HIGH_SALARY_SUPPORT = 1;
    const IS_HIGH_SALARY_NOT_SUPPORT = 2;
    public static $isHighSalary = [
        self::IS_HIGH_SALARY_SUPPORT => '支持高薪帮',
        self::IS_HIGH_SALARY_NOT_SUPPORT => '不支持高薪帮',
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
            'id' => '机构id',
            'org_short_name' => '机构简称',
            'org_name' => '机构全程',
            'org_type' => '机构类型',
            'parent_id' => '总校',
            'status' => '状态',
            'is_shelf' => '是否上架',
            'is_delete' => '是否删除',
            'is_employment' => '是否支持就业帮',
            'is_high_salary' => '是否支持高薪帮',
            'created_time' => '创建时间',
            'updated_time' => '更新时间',
        ];
    }
}
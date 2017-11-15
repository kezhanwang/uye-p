<?php
/**
 * Created by PhpStorm.
 * User: wangyi
 * Date: 2017/9/23
 * Time: 上午9:21
 */

namespace common\models\ar;

use components\ArrayUtil;
use components\RedisUtil;
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

    /**
     * @param $id 机构id
     * @param int $status 机构状态，默认审核通过
     * @param int $shelf 机构是否上架，默认上架
     * @param bool $needDesp 是否需要机构简介，默认不需要
     * @param bool $cache 是否需要从cache中取，默认需要
     * @return array|bool|mixed|null|\yii\db\ActiveRecord
     */
    public static function getOrgById($id, $status = self::STATUS_OK, $shelf = self::IS_DELETE_ON, $needDesp = false, $cache = true)
    {
        if (empty($id) || !is_numeric($id)) {
            return false;
        }
        $redis = RedisUtil::getInstance();
        $redisKey = 'UYE_ORG_INFO_' . md5($id);
        $data = $redis->get($redisKey);
        if ($data && $cache) {
            $org = json_decode($data, true);
            if (!$needDesp) {
                unset($org['description']);
            }
            return $org;
        } else {
            $query = self::find()
                ->select('o.*,oi.*,c.name as category')
                ->from(self::TABLE_NAME . ' o')
                ->leftJoin(UyeOrgInfo::TABLE_NAME . ' oi', 'oi.org_id=o.id')
                ->leftJoin(UyeCategory::TABLE_NAME . ' c', 'c.id=oi.category_1')
                ->where('o.id=:id', [':id' => $id]);
            if ($status) {
                $query->andWhere('o.status=:status', [':status' => $status]);
            }
            if ($shelf) {
                $query->andWhere('o.is_shelf=:is_shelf', [':is_shelf' => $shelf]);
            }
            $org = $query->asArray()->one();
            if (empty($org)) {
                return [];
            } else {
                $redis->set($redisKey, json_encode($org));
                if (!$needDesp) {
                    unset($org['description']);
                }
                return $org;
            }
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

    public static function _add($info = [])
    {
        if (empty($info)) {
            throw new UException(ERROR_SYS_PARAMS_CONTENT, ERROR_SYS_PARAMS);
        }

        $info = ArrayUtil::trimArray($info);
        $ar = new UyeOrg();
        $ar->setIsNewRecord(true);
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
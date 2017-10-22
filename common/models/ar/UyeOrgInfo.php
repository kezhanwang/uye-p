<?php

namespace common\models\ar;

use components\ArrayUtil;
use components\UException;


/**
 * This is the model class for table "uye_org_info".
 *
 * @property integer $org_id
 * @property string $logo
 * @property string $description
 * @property integer $province
 * @property integer $city
 * @property integer $area
 * @property string $address
 * @property double $map_lng
 * @property double $map_lat
 * @property string $phone
 * @property string $employment_index
 * @property string $avg_course_price
 * @property integer $created_time
 * @property integer $updated_time
 */
class UyeOrgInfo extends UActiveRecord
{
    const TABLE_NAME = 'uye_org_info';

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
    public function rules()
    {
        return [
            [['org_id', 'logo'], 'required'],
            [['org_id', 'province', 'city', 'area', 'created_time', 'updated_time'], 'integer'],
            [['description', 'address'], 'string'],
            [['map_lng', 'map_lat', 'employment_index', 'avg_course_price'], 'number'],
            [['logo'], 'string', 'max' => 500],
            [['phone'], 'string', 'max' => 14],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'org_id' => 'Org ID',
            'logo' => 'Logo',
            'description' => 'Description',
            'province' => 'Province',
            'city' => 'City',
            'area' => 'Area',
            'address' => '详细地址',
            'map_lng' => 'Map Lng',
            'map_lat' => 'Map Lat',
            'phone' => '咨询电话',
            'employment_index' => '就业指数',
            'avg_course_price' => 'Avg Course Price',
            'created_time' => 'Created Time',
            'updated_time' => 'Updated Time',
        ];
    }

    public static function _addOrgInfo($info)
    {
        if (empty($info)) {
            throw new UException(ERROR_SYS_PARAMS_CONTENT, ERROR_SYS_PARAMS);
        }

        $ar = new UyeOrgInfo();
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
            UException::dealAR($ar);
        }
        return $ar->getAttributes();
    }

    public static function _updateOrgInfo($id, $info)
    {
        if (empty($id) || empty($info)) {
            throw new UException(ERROR_SYS_PARAMS_CONTENT, ERROR_SYS_PARAMS);
        }

        $ar = self::findOne($id);
        $attributes = $ar->getAttributes();
        $info = ArrayUtil::trimArray($info);
        foreach ($attributes as $key => $attribute) {
            if (!empty($info[$key])) {
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

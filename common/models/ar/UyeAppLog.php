<?php
/**
 * Created by PhpStorm.
 * User: wangyi
 * Date: 2017/10/10
 * Time: 下午2:17
 */

namespace common\models\ar;

use components\ArrayUtil;
use components\UException;

/**
 * This is the model class for table "uye_app_log".
 *
 * @property integer $id
 * @property string $phoneid
 * @property integer $uid
 * @property double $map_lng
 * @property double $map_lat
 * @property string $country
 * @property string $province
 * @property string $city
 * @property string $district
 * @property string $street
 * @property string $street_number
 * @property integer $request_time
 * @property integer $created_time
 * @property integer $updated_time
 */
class UyeAppLog extends UActiveRecord
{
    const TABLE_NAME = 'uye_app_log';

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
            'id' => 'id',
            'phoneid' => 'Phoneid',
            'uid' => 'Uid',
            'map_lng' => 'Map Lng',
            'map_lat' => 'Map Lat',
            'country' => 'Country',
            'province' => 'Province',
            'city' => 'City',
            'district' => 'District',
            'street' => 'Street',
            'street_number' => 'Street Number',
            'request_time' => 'Request Time',
            'created_time' => 'Created Time',
            'updated_time' => 'Updated Time',
        ];
    }

    public static function _addLog($info)
    {
        if (empty($info)) {
            throw new UException(ERROR_SYS_PARAMS_CONTENT, ERROR_SYS_PARAMS);
        }

        $ar = new UyeAppLog();
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

    public static function _updateLog($id, $info)
    {
        if (empty($id) || empty($info)) {
            throw new UException(ERROR_SYS_PARAMS_CONTENT, ERROR_SYS_PARAMS);
        }

        $ar = self::findOne(['id' => $id]);
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
}
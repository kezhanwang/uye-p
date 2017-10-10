<?php
/**
 * Created by PhpStorm.
 * User: wangyi
 * Date: 2017/10/9
 * Time: 下午7:03
 */

namespace common\models\ar;

/**
 * This is the model class for table "uye_search_log".
 *
 * @property integer $id
 * @property string $filter
 * @property string $words
 * @property integer $uid
 * @property double $map_lng
 * @property double $map_lat
 * @property string $request
 * @property integer $created_time
 */
class UyeSearchLog extends UActiveRecord
{
    const TABLE_NAME = 'uye_search_log';

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
            'filter' => 'Filter',
            'words' => 'Words',
            'uid' => 'Uid',
            'map_lng' => 'Map Lng',
            'map_lat' => 'Map Lat',
            'request' => 'Request',
            'created_time' => 'Created Time',
        ];
    }

    public static function addSearchLog($lng, $lat, $uid, $words, $filter, $request)
    {
        $ar = new UyeSearchLog();
        $ar->setIsNewRecord(true);
        $ar->map_lng = $lng;
        $ar->map_lat = $lat;
        $ar->uid = $uid;
        $ar->words = $words;
        $ar->filter = $filter;
        $ar->request = $request;
        $ar->created_time = time();

        if (!$ar->save()) {
            throw new UException(var_export($ar->getErrors(), true), ERROR_DB);
        }
        return true;
    }
}
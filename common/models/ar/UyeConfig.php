<?php

namespace common\models\ar;

use components\ArrayUtil;
use components\RedisUtil;
use components\UException;


/**
 * This is the model class for table "uye_config".
 *
 * @property integer $id
 * @property string $name
 * @property string $label
 * @property string $value
 * @property integer $created_time
 * @property integer $updated_time
 */
class UyeConfig extends UActiveRecord
{
    const TABLE_NAME = 'uye_config';

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
            'name' => 'Name',
            'label' => 'Label',
            'value' => 'Value',
            'created_time' => 'Created Time',
            'updated_time' => 'Updated Time',
        ];
    }

    public static function _addConfig($info)
    {
        if (empty($info)) {
            throw new UException(ERROR_SYS_PARAMS_CONTENT, ERROR_SYS_PARAMS);
        }

        $ar = new UyeConfig();
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

    public static function _updateConfig($id, $info)
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

    public static function getConfig($name)
    {
        if (empty($name)) {
            return [];
        }

        $redis = RedisUtil::getInstance();
        $redisKey = 'UYE-CONFIG-' . $name;
        $data = $redis->get($redisKey);
        if ($data) {
            return json_decode($data, true);
        } else {
            $config = static::find()
                ->select('*')
                ->from(self::TABLE_NAME)
                ->where('name=:name', [':name' => $name])
                ->asArray()->one();

            if (empty($config)) {
                return [];
            } else {
                $redis->set($redisKey, json_encode($config));
                return $config;
            }
        }

    }
}

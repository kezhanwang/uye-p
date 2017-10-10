<?php

namespace common\models\ar;

use components\ArrayUtil;
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
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'uye_config';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['created_time', 'updated_time'], 'integer'],
            [['name'], 'string', 'max' => 20],
            [['label'], 'string', 'max' => 50],
            [['value'], 'string', 'max' => 255],
            [['name'], 'unique'],
        ];
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
            throw new UException(var_export($ar->getErrors(), true), ERROR_DB);
        }
        return $ar->getAttributes();
    }

    public static function _updateConfig($id, $info)
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

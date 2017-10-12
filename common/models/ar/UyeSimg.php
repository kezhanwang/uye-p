<?php
/**
 * Created by PhpStorm.
 * User: wangyi
 * Date: 2017/10/12
 * Time: 下午5:04
 */

namespace common\models\ar;

use components\ArrayUtil;
use components\UException;

/**
 * This is the model class for table "uye_simg".
 *
 * @property integer $id
 * @property integer $uid
 * @property string $path
 * @property string $year_month
 * @property string $day
 * @property string $file_name
 * @property string $file_suffix
 * @property integer $type
 * @property integer $create_time
 */
class UyeSimg extends UActiveRecord
{
    const TABLE_NAME = 'uye_simg';

    const SIMG_TYPE_INSTALMENT = 1;

    const SIMG_TYPE_BUSINESS = 2;


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
            'uid' => 'Uid',
            'path' => 'Path',
            'year_month' => 'Year Month',
            'day' => 'Day',
            'file_name' => 'File Name',
            'file_suffix' => 'File Suffix',
            'type' => 'Type',
            'create_time' => 'Create Time',
        ];
    }

    /**
     * 根据访问路径获取图片相关信息.
     * @param null $path
     * @return array|bool|null|\yii\db\ActiveRecord
     */
    public static function getSimgByPath($path = null)
    {
        if ($path === null) {
            return false;
        }

        $result = self::find()->select('*')->where('path=:path', [':path' => $path])->asArray()->one();
        if ($result) {
            return $result;
        } else {
            return false;
        }
    }

    /**
     * 添加新的图片信息.
     * @param array $info
     * @return array|bool
     * @throws UException
     */
    public static function _insert($info = array())
    {
        if (empty($info)) {
            return false;
        }

        $ar = new UyeSimg();
        $ar->setIsNewRecord(true);
        $attributes = $ar->getAttributes();
        $info = ArrayUtil::trimArray($info);
        foreach ($attributes as $key => $value) {
            if (isset($info[$key])) {
                $ar->$key = $info[$key];
            }
        }
        if (!$ar->save()) {
            UException::dealAR($ar);
        }
        return $ar->getAttributes();
    }

    /**
     * 根据id更新
     * @param $id
     * @param array $fieldData
     * @return array|bool
     * @throws UException
     */
    public static function _update($id, $fieldData = array())
    {
        if ($id < 1 || empty($fieldData)) {
            return false;
        }
        $ar = self::findOne("id = {$id}");

        foreach ($fieldData as $k => $v) {
            $ar->$k = $v;
        }
        if (!$ar->save()) {
            UException::dealAR($ar);
        }
        return $ar->getAttributes();
    }
}
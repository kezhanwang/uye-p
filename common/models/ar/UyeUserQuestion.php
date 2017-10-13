<?php
/**
 * Created by PhpStorm.
 * User: wangyi
 * Date: 2017/10/12
 * Time: 下午8:07
 */

namespace common\models\ar;

use components\ArrayUtil;
use components\UException;

/**
 * This is the model class for table "uye_user_question".
 *
 * @property integer $id
 * @property integer $uid
 * @property integer $org_id
 * @property string $question
 * @property integer $created_time
 * @property integer $updated_time
 */
class UyeUserQuestion extends UActiveRecord
{
    const TABLE_NAME = 'uye_user_question';

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
            'org_id' => 'Org ID',
            'question' => 'Question',
            'created_time' => 'Created Time',
            'updated_time' => 'Updated Time',
        ];
    }

    public static function _add($info)
    {
        if (empty($info)) {
            throw new UException(ERROR_SYS_PARAMS_CONTENT, ERROR_SYS_PARAMS);
        }

        $ar = new UyeUserQuestion();
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
}
<?php
/**
 * Created by PhpStorm.
 * User: wangyi
 * Date: 2017/10/23
 * Time: 下午6:34
 */

namespace common\models\ar;

/**
 * Class UyeEUserRole
 * @package common\models\ar
 *
 * @property integer $id
 * @property integer $uid
 * @property integer $role_id
 * @property integer $created_time
 * @property integer $updated_time
 * @property string $password write-only password
 */

class UyeEUserRole extends UActiveRecord
{
    const TABLE_NAME = 'uye_e_user_role';

    public static function tableName()
    {
        return self::TABLE_NAME;
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'uid' => 'UID',
            'role_id' => '角色id',
            'created_time' => '创建时间',
            'updated_time' => '更新时间',
        ];
    }
}
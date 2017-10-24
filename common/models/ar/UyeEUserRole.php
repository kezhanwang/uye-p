<?php
/**
 * Created by PhpStorm.
 * User: wangyi
 * Date: 2017/10/23
 * Time: 下午6:34
 */

namespace common\models\ar;


class UyeEUserRole extends UActiveRecord
{
    const TABLE_NAME = 'uye_e_user_role';

    public static function tableName()
    {
        return self::TABLE_NAME;
    }
}
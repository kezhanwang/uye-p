<?php
/**
 * Created by PhpStorm.
 * User: wangyi
 * Date: 2017/10/23
 * Time: 下午6:33
 */

namespace common\models\ar;


class UyeERole extends UActiveRecord
{
    const TABLE_NAME = 'uye_e_role';

    public static function tableName()
    {
        return self::TABLE_NAME;
    }
}
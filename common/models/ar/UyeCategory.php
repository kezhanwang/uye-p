<?php
/**
 * Created by PhpStorm.
 * User: wangyi
 * Date: 2017/9/30
 * Time: 下午5:30
 */

namespace common\models\ar;


class UyeCategory extends UActiveRecord
{
    const TABLE_NAME = 'uye_category';

    public static function tableName()
    {
        return self::TABLE_NAME; // TODO: Change the autogenerated stub
    }

}
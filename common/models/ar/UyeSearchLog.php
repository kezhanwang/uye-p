<?php
/**
 * Created by PhpStorm.
 * User: wangyi
 * Date: 2017/10/9
 * Time: 下午7:03
 */

namespace common\models\ar;


class UyeSearchLog extends UActiveRecord
{
    const TABLE_NAME = 'uye_search_log';

    public static function tableName()
    {
        return self::TABLE_NAME;
    }


}
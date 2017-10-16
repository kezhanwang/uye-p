<?php
/**
 * Created by PhpStorm.
 * User: wangyi
 * Date: 2017/10/16
 * Time: 下午6:30
 */

namespace common\models\ar;


class UyeAreas extends UActiveRecord
{
    const TABLE_NAME = 'uye_areas';

    public static function tableName()
    {
        return self::TABLE_NAME;
    }

    public static function getAreas($parent_id = -1, $id = 0)
    {
        $sql = self::find()
            ->select("areaid id,name,parentid,joinname")
            ->from(self::TABLE_NAME);

        if ($id > 0) {
            $sql->where("areaid=:areaid", [':areaid' => $id]);
        }
        if ($parent_id > -1) {
            $sql->where("parentid=:parentid", [':parentid' => $parent_id]);
        }
        $sql->orderBy("name ASC , vieworder ASC");
        $list = $sql->asArray()->all();
        return $list;
    }
}
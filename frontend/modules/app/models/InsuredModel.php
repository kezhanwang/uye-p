<?php
/**
 * Created by PhpStorm.
 * User: wangyi
 * Date: 2017/10/13
 * Time: 上午11:14
 */

namespace app\modules\app\models;


use common\models\ar\UyeCategory;
use common\models\ar\UyeOrg;
use common\models\ar\UyeOrgCourse;
use common\models\ar\UyeOrgInfo;
use components\NearbyUtil;
use components\PicUtil;
use components\UException;

class InsuredModel
{
    public static function getOrganize($org_id)
    {
        $fields = "o.*,oi.*,c.name as category";
        $organize = UyeOrg::find()
            ->select($fields)
            ->from(UyeOrg::TABLE_NAME . " o")
            ->leftJoin(UyeOrgInfo::TABLE_NAME . " oi", "oi.org_id=o.id")
            ->leftJoin(UyeCategory::TABLE_NAME . " c", "c.id=oi.category_1")
            ->where("o.id=:id AND o.status=:status AND o.is_shelf=:is_shelf AND o.is_employment=:is_employment", [':id' => $org_id, ':status' => UyeOrg::STATUS_OK, ':is_shelf' => UyeOrg::IS_SHELF_ON, ':is_employment' => UyeOrg::IS_EMPLOYMENT_SUPPORT])
            ->asArray()
            ->one();
        if (empty($organize)) {
            throw new UException(ERROR_ORG_NOT_EXISTS_CONTENT, ERROR_ORG_NOT_EXISTS);
        }
        unset($organize['description']);
        $organize['logo'] = PicUtil::getUrl($organize['logo']);
        return $organize;
    }

    public static function getCourses($org_id)
    {
        $fields = "id AS c_id,name AS c_name";
        $courses = UyeOrgCourse::find()
            ->select($fields)
            ->where('org_id=:org_id', [':org_id' => $org_id])
            ->asArray()
            ->all();
        if (empty($courses)) {
            $courses = [];
        }

        return $courses;
    }
}
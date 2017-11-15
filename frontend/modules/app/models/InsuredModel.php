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
        $organize = UyeOrg::getOrgById($org_id);
        if (empty($organize)) {
            throw new UException(ERROR_ORG_NOT_EXISTS_CONTENT, ERROR_ORG_NOT_EXISTS);
        }

        if ($organize['is_employment'] != UyeOrg::IS_EMPLOYMENT_SUPPORT) {
            throw new UException(ERROR_ORG_NO_SUPPORT_EMPLOYMENT_CONTENT, ERROR_ORG_NO_SUPPORT_EMPLOYMENT);
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
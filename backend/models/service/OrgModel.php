<?php
/**
 * Created by PhpStorm.
 * User: wangyi
 * Date: 2017/10/23
 * Time: 上午10:57
 */

namespace backend\models\service;


use common\models\ar\UyeAreas;
use common\models\ar\UyeCategory;
use common\models\ar\UyeOrg;
use common\models\ar\UyeOrgInfo;
use common\models\ar\UyeOrgCourse;
use common\models\opensearch\OrgSearch;
use components\PicUtil;
use components\RedisUtil;
use components\UException;
use yii\web\NotFoundHttpException;

class OrgModel
{
    public static function getOrgInfo($id)
    {
        $info = UyeOrg::getOrgById($id, null, null, true);
        if (empty($info)) {
            throw new NotFoundHttpException("未查询到机构信息");
        }
        return $info;
    }

    public static function createOrg($params)
    {
        $orgKey = [
            'org_name', 'org_short_name', 'org_type', 'is_employment', 'employment_rate', 'is_high_salary', 'business', 'province', 'city', 'area', 'address', 'map_lng', 'map_lat', 'phone', 'category_1', 'editorValue', 'logo', 'logo_x', 'logo_y', 'logo_w', 'logo_h'
        ];

        $org = [];

        foreach ($orgKey as $item) {
            if (!array_key_exists($item, $params)) {
                throw new NotFoundHttpException(ERROR_SYS_PARAMS_CONTENT . ":" . $item, ERROR_SYS_PARAMS);
            } else {
                $org[$item] = $params[$item];
            }
        }
        $org['status'] = UyeOrg::STATUS_SAVE;
        if ($params['parent_id']) {
            $org['parent_id'] = $params['parent_id'];
        } else {
            $org['parent_id'] = 0;
        }
        $orgInfo = UyeOrg::_add($org);

        if ($org['parent_id'] == 0) {
            UyeOrg::_update($orgInfo['id'], ['parent_id' => $orgInfo['id']]);
        }

        $params['org_id'] = $orgInfo['id'];
        $params['logo'] = PicUtil::getLogo($org['logo'], $org['logo_x'], $org['logo_y'], $org['logo_w'],
            $org['logo_h']);
        $params['description'] = $params['editorValue'];
        UyeOrgInfo::_addOrgInfo($params);
        return $orgInfo;
    }

    public static function getArea($province, $city)
    {
        $redis = RedisUtil::getInstance();
        $key = "UYE_GET_PROVINCE";
        $data = $redis->get($key);
        if ($data) {
            $list1 = json_decode($data, true);
        } else {
            $list1 = UyeAreas::getAreas(0);

            foreach ($list1 as &$item) {
                unset($item['parentid']);
                unset($item['joinname']);
                list($item['letter'], $item['name']) = explode('-', $item['name']);
            }

            $redis->set($key, json_encode($list1));
        }

        $key = "UYE_GET_CITY_BY_PROVINCE_" . $province;
        $data = $redis->get($key);
        if ($data) {
            $list2 = json_decode($data, true);
        } else {
            $list2 = UyeAreas::getAreas($province);
            foreach ($list2 as &$item) {
                unset($item['parentid']);
                unset($item['joinname']);
            }

            $redis->set($key, json_encode($list2));
        }

        $key = "UYE_GET_AREA_BY_CITY_" . $city;
        $data = $redis->get($key);
        if ($data) {
            $list3 = json_decode($data, true);
        } else {
            $list3 = UyeAreas::getAreas($city);
            foreach ($list3 as &$item) {
                unset($item['parentid']);
                $item['joinname'] = str_replace(',', '', $item['joinname']);
            }
            $redis->set($key, json_encode($list3));
        }

        return [
            'province' => $list1,
            'city' => $list2,
            'area' => $list3
        ];
    }

    public static function auth($id, $status)
    {
        if (empty($id) || !is_numeric($id) || empty($status) || !is_numeric($status)) {
            throw new UException(ERROR_SYS_PARAMS_CONTENT, ERROR_SYS_PARAMS);
        }

        $org = UyeOrg::getOrgById($id, null, null, true);
        if (empty($org)) {
            throw new UException(ERROR_ORG_NO_EXISTS_CONTENT, ERROR_ORG_NO_EXISTS);
        }

        if ($org['status'] == UyeOrg::STATUS_OK) {
            throw new UException("机构已通过审核，请勿重复操作！", ERROR_SYS_PARAMS);
        }

        try {
            UyeOrg::_update($org['id'], ['status' => $status]);
            return true;
        } catch (UException $exception) {
            throw new UException($exception->getMessage(), $exception->getCode());
        }
    }

    public static function shelf($id, $shelf)
    {
        if (empty($id) || !is_numeric($id) || empty($shelf) || !is_numeric($shelf)) {
            throw new UException(ERROR_SYS_PARAMS_CONTENT, ERROR_SYS_PARAMS);
        }

        $org = UyeOrg::getOrgById($id, null, null, true);
        if (empty($org)) {
            throw new UException(ERROR_ORG_NO_EXISTS_CONTENT, ERROR_ORG_NO_EXISTS);
        }

        try {
            UyeOrg::_update($org['id'], ['is_shelf' => $shelf]);
            self::updateOpenSearch($org['id']);
            self::updateRedis($org['id']);
            return true;
        } catch (UException $exception) {
            throw new UException($exception->getMessage(), $exception->getCode());
        }
    }

    public static function updateOpenSearch($id)
    {
        $fields = "o.*,oi.*,c.name as category";
        $org = UyeOrg::find()
            ->select($fields)
            ->from(UyeOrg::TABLE_NAME . " o")
            ->leftJoin(UyeOrgInfo::TABLE_NAME . " oi", "oi.org_id=o.id")
            ->leftJoin(UyeCategory::TABLE_NAME . " c", "c.id=oi.category_1")
            ->where('o.id=:id', [':id' => $id])
            ->asArray()
            ->all();
        OrgSearch::createPush($org);
    }

    public static function updateRedis($id)
    {
        UyeOrg::getOrgById($id, null, null, true, false);
    }

    public static function createCourse($params = [])
    {
        $key = [
            'org_id', 'name', 'unit_price', 'logo', 'logo_x', 'logo_y', 'logo_w', 'logo_h'
        ];

        $course = [];

        foreach ($key as $item) {
            if (!array_key_exists($item, $params)) {
                throw new NotFoundHttpException(ERROR_SYS_PARAMS_CONTENT . ":" . $item, ERROR_SYS_PARAMS);
            } else {
                $course[$item] = $params[$item];
            }
        }
        $course['logo'] = PicUtil::getLogo($params['logo'], $params['logo_x'], $params['logo_y'], $params['logo_w'], $params['logo_h']);
        $course['unit_price'] = $course['unit_price'] * 100;
        try {
            UyeOrgCourse::_add($course);
            $avg = UyeOrgCourse::getAvgUnitByOrgID($course['org_id']);
            UyeOrgInfo::_updateOrgInfo($course['org_id'], ['avg_course_price' => $avg]);
            self::updateOpenSearch($course['org_id']);
            self::updateRedis($course['id']);
            return true;
        } catch (UException $exception) {
            throw new UException($exception->getMessage(), $exception->getCode());
        }
    }
}
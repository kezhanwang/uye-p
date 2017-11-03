<?php
/**
 * Created by PhpStorm.
 * User: wangyi
 * Date: 2017/10/23
 * Time: 上午10:57
 */

namespace backend\models\service;


use common\models\ar\UyeAreas;
use common\models\ar\UyeOrg;
use common\models\ar\UyeOrgInfo;
use components\PicUtil;
use components\RedisUtil;
use components\UException;
use yii\web\NotFoundHttpException;

class OrgModel
{
    public static function getOrgInfo($id)
    {
        $info = UyeOrg::find()
            ->select('*')
            ->from(UyeOrg::TABLE_NAME . " o")
            ->leftJoin(UyeOrgInfo::TABLE_NAME . " oi", "oi.org_id=o.id")
            ->where('o.id=:id', [':id' => $id])
            ->asArray()
            ->one();

        if (empty($info)) {
            throw new NotFoundHttpException("未查询到机构信息");
        }
        return $info;
    }

    public static function createOrg($params)
    {
        $orgKey = ['org_name', 'org_short_name', 'org_type', 'is_employment', 'employment_rate', 'is_high_salary', 'business', 'province',
            'city', 'area', 'address', 'map_lng', 'map_lat', 'phone', 'category_1', 'editorValue', 'logo', 'logo_x', 'logo_y', 'logo_w', 'logo_h'
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
        $params['logo'] = PicUtil::getLogo($org['logo'], $org['logo_x'], $org['logo_y'], $org['logo_w'], $org['logo_h']);
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
}
<?php
/**
 * Created by PhpStorm.
 * User: wangyi
 * Date: 2017/10/23
 * Time: 上午10:41
 */

namespace backend\models\service;


use common\models\ar\UyeInsuredOrder;
use common\models\ar\UyeInsuredWater;
use common\models\ar\UyeOrg;
use common\models\ar\UyeOrgCourse;
use common\models\ar\UyeUserIdentity;
use yii\data\Pagination;
use yii\db\Expression;
use yii\web\NotFoundHttpException;

class InsuredModel
{
    public static function getInsuredList($params = [])
    {
        $query = UyeInsuredOrder::find()
            ->select('io.*,ui.full_name,ui.id_card,ui.auth_mobile,o.org_name,oc.name as c_name')
            ->from(UyeInsuredOrder::TABLE_NAME . " io")
            ->leftJoin(UyeOrg::TABLE_NAME . " o", "o.id=io.org_id")
            ->leftJoin(UyeOrgCourse::TABLE_NAME . " oc", "oc.id=io.c_id")
            ->leftJoin(UyeUserIdentity::TABLE_NAME . " ui", "ui.uid=io.uid");

        if ($params['key']) {
            $query->andWhere(" io.insured_order LIKE '%{$params['key']}%' OR io.uid LIKE '%{$params['key']}%' OR ui.full_name LIKE '%{$params['key']}%'");
        }

        if ($params['org']) {
            if (is_numeric($params['org'])) {
                $query->andWhere('io.org_id=:org_id OR o.parent_id=:parent_id', [':org_id' => $params['org'], ':parent_id' => $params['org']]);
            } else {
                $query->andWhere("o.org_name LIKE '%{$params['org']}%'");
            }
        }

        if ($params['insured_type']) {
            $query->andWhere('io.insured_type=:insured_type', [':insured_type' => $params['insured_type']]);
        }

        if ($params['insured_status']) {
            $query->andWhere('io.insured_status=:insured_status', [':insured_status' => $params['insured_status']]);
        }

        if ($params['auth_mobile']) {
            $query->andWhere('ui.auth_mobile=:auth_mobile', [':auth_mobile' => $params['auth_mobile']]);
        }

        if ($params['id_card']) {
            $query->andWhere('ui.id_card=:id_card', [':id_card' => $params['id_card']]);
        }
        $pages = new Pagination(['totalCount' => $query->count(), 'pageSize' => '10']);
        $insuredList = $query->orderBy('io.id desc')->offset($pages->offset)->limit($pages->limit)->asArray()->all();
        return [
            'pages' => $pages,
            'insureds' => $insuredList
        ];
    }

    public static function getInsuredInfo($id)
    {
        $info = UyeInsuredOrder::find()
            ->select('io.*,o.org_name,ui.id_card,oc.name as c_name')
            ->from(UyeInsuredOrder::TABLE_NAME . " io")
            ->leftJoin(UyeOrg::TABLE_NAME . " o", "o.id=io.org_id")
            ->leftJoin(UyeUserIdentity::TABLE_NAME . " ui", "ui.uid=io.uid")
            ->leftJoin(UyeOrgCourse::TABLE_NAME . " oc", "oc.id=io.c_id")
            ->where('io.id=:id', [':id' => $id])
            ->asArray()
            ->one();

        if (empty($info)) {
            throw new NotFoundHttpException("为查询订单信息");
        }

        return $info;
    }

    public static function getWaterList($params)
    {
        $query = UyeInsuredWater::find()
            ->select('iw.*,io.insured_order,io.insured_status,o.org_name')
            ->from(UyeInsuredWater::TABLE_NAME . " iw")
            ->leftJoin(UyeInsuredOrder::TABLE_NAME . " io", "io.id=iw.insured_id")
            ->leftJoin(UyeOrg::TABLE_NAME . " o", "o.id=io.org_parent_id");

        if ($params['org']) {
            if (is_numeric($params['org'])) {
                $query->andWhere('io.org_id=:org_id OR o.parent_id=:parent_id', [':org_id' => $params['org'], ':parent_id' => $params['org']]);
            } else {
                $query->andWhere("o.org_name LIKE '%{$params['org']}%'");
            }
        }

        if (!$params['status']) {
            $query->andWhere('iw.status=:status', [':status' => UyeInsuredWater::ACCOUNTING_STATUS_NO]);
        } else {
            $query->andWhere('iw.status=:status', [':status' => $params['status']]);
        }

        $pages = new Pagination(['totalCount' => $query->count(), 'pageSize' => '10']);
        $insuredList = $query->orderBy('iw.id desc')->offset($pages->offset)->limit($pages->limit)->asArray()->all();
        return [
            'pages' => $pages,
            'waters' => $insuredList
        ];


    }
}
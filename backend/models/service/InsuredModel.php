<?php
/**
 * Created by PhpStorm.
 * User: wangyi
 * Date: 2017/10/23
 * Time: 上午10:41
 */

namespace backend\models\service;


use common\models\ar\UyeInsuredLog;
use common\models\ar\UyeInsuredOrder;
use common\models\ar\UyeInsuredWater;
use common\models\ar\UyeOrg;
use common\models\ar\UyeOrgCourse;
use common\models\ar\UyeUserIdentity;
use common\models\ar\UyeUserMobile;
use components\UException;
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
        $insuredInfo = UyeInsuredOrder::find()
            ->select('io.*,o.org_name,oc.name as c_name,ui.*')
            ->from(UyeInsuredOrder::TABLE_NAME . " io")
            ->leftJoin(UyeOrg::TABLE_NAME . " o", "o.id=io.org_id")
            ->leftJoin(UyeOrgCourse::TABLE_NAME . " oc", "oc.id=io.c_id")
            ->leftJoin(UyeUserIdentity::TABLE_NAME . " ui", "ui.uid=io.uid")
            ->where('io.id=:id', [':id' => $id])
            ->asArray()
            ->one();

        if (empty($insuredInfo)) {
            throw new NotFoundHttpException("暂未获取订单信息");
        }

        $mobile = UyeUserMobile::find()
            ->select('*')
            ->from(UyeUserMobile::TABLE_NAME)
            ->where('uid=:uid', [':uid' => $insuredInfo['uid']])
            ->asArray()->one();

        if ($mobile) {
            $mobileArr = json_decode($mobile['list'], true);
        } else {
            $mobileArr = [];
        }


        $log = UyeInsuredLog::find()
            ->select('*')
            ->from(UyeInsuredLog::TABLE_NAME)
            ->where("insured_id=:insured_id", [':insured_id' => $insuredInfo['id']])
            ->asArray()->all();
        return [
            'insured_order' => $insuredInfo,
            'mobile' => $mobileArr,
            'log' => $log
        ];
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

    /**
     * @param $params
     * @return bool
     * @throws UException
     */
    public static function checkInsured($params)
    {
        if (empty($params)) {
            throw new UException(ERROR_SYS_PARAMS_CONTENT, ERROR_SYS_PARAMS);
        }

        $insured = UyeInsuredOrder::findOne($params['id'])->getAttributes();
        if (empty($insured)) {
            throw new UException(ERROR_INSURED_NOT_EXISTS_CONTENT, ERROR_INSURED_NOT_EXISTS);
        }

        if ($insured['insured_status'] != INSURED_STATUS_CREATE) {
            throw new UException(ERROR_INSURED_NOT_STATUS_CONTENT, ERROR_INSURED_NOT_STATUS);
        }

        if ($params['type'] == 1) {
            $insured_status = INSURED_STATUS_VERIFY_PASS;
        } else {
            $insured_status = INSURED_STATUS_VERIFY_REFUSE;
        }

        $update = [
            'insured_status' => $insured_status,
            'remark' => $params['remark']
        ];


        UyeInsuredOrder::_update($params['id'], $update);
        UyeInsuredLog::_addLog($params['id'], $insured['insured_order'], $insured['insured_status'], $insured_status, \Yii::$app->user->getId(), json_encode($update), $params['remark']);
        return true;
    }

    public static function checkWater($id)
    {
        if (empty($id) || !is_numeric($id)) {
            throw new UException(ERROR_SYS_PARAMS_CONTENT, ERROR_SYS_PARAMS);
        }

        $water = UyeInsuredWater::findOne($id)->getAttributes();
        if (empty($water)) {
            throw new UException(ERROR_INSURED_WATER_NOT_EXISTS_CONTENT，ERROR_INSURED_WATER_NOT_EXISTS);
        }

        if ($water['status'] == UyeInsuredWater::ACCOUNTING_STATUS_YES) {
            throw new UException(ERROR_INSURED_NOT_STATUS_CONTENT, ERROR_INSURED_NOT_STATUS);
        }

        $insured = UyeInsuredOrder::findOne($water['insured_id'])->getAttributes();
        if (empty($insured)) {
            throw new UException(ERROR_INSURED_NOT_EXISTS_CONTENT, ERROR_INSURED_NOT_EXISTS);
        }

        if ($insured['insured_status'] != INSURED_STATUS_PAY) {
            throw new UException(ERROR_INSURED_NOT_STATUS_CONTENT, ERROR_INSURED_NOT_STATUS);
        }

        $waterUpdate = [
            'status' => UyeInsuredWater::ACCOUNTING_STATUS_YES,
            'updated_time' => time(),
        ];

        $insuredUpdate = [
            'insured_status' => INSURED_STATUS_PAYMENT
        ];
        

        UyeInsuredOrder::_update($insured['id'], $insuredUpdate);
        UyeInsuredWater::_update($id, $waterUpdate);
        UyeInsuredLog::_addLog($insured['id'], $insured['insured_order'], $insured['insured_status'], INSURED_STATUS_PAYMENT, \Yii::$app->user->getId(), json_encode($waterUpdate), '保单服务费核算，进入培训期');
        return true;
    }
}
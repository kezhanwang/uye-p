<?php
/**
 * Created by PhpStorm.
 * User: wangyi
 * Date: 2017/10/23
 * Time: 上午11:44
 */

namespace e\models\service;


use common\models\ar\UyeInsuredLog;
use common\models\ar\UyeInsuredOrder;
use common\models\ar\UyeOrg;
use common\models\ar\UyeOrgCourse;
use common\models\ar\UyeUser;
use common\models\ar\UyeUserIdentity;
use common\models\ar\UyeUserMobile;
use components\CsvUtil;
use components\UException;
use yii\data\Pagination;
use yii\web\NotFoundHttpException;

class InsuredModel
{
    public static function getInsuredOrders($params, $org_id)
    {
        if (empty($org_id)) {
            return [];
        }

        $data = UyeInsuredOrder::find()
            ->select('io.*,ui.full_name,ui.id_card,ui.auth_mobile,o.org_name,oc.name as c_name')
            ->from(UyeInsuredOrder::TABLE_NAME . " io")
            ->leftJoin(UyeUserIdentity::TABLE_NAME . " ui", 'ui.uid=io.uid')
            ->leftJoin(UyeOrg::TABLE_NAME . " o", "o.id=io.org_id")
            ->leftJoin(UyeOrgCourse::TABLE_NAME . " oc", "oc.id=io.c_id");
        if ($params['key']) {
            $data->andWhere("io.insured_order LIKE '%{$params['key']}%' OR ui.full_name LIKE '%{$params['key']}%' OR ui.auth_mobile LIKE '%{$params['key']}%' OR ui.id_card LIKE '%{$params['key']}%'");
        }

        if ($params['insured_status']) {
            $data->andWhere('io.insured_status=:insured_status', [':insured_status' => $params['insured_status']]);
        }

        if ($params['beginDate']) {
            $data->andWhere('io.created_time >= :beginDate', [':beginDate' => strtotime($params['beginDate'])]);
        }

        if ($params['endDate']) {
            $data->andWhere('io.created_time <= :endDate', [':endDate' => strtotime($params['endDate'])]);
        }

        if ($params['paybeginDate']) {
            $data->andWhere('io.created_time >= :paybeginDate', [':beginDate' => strtotime($params['paybeginDate'])]);
        }

        if ($params['payendDate']) {
            $data->andWhere('io.created_time <= :payendDate', [':payendDate' => strtotime($params['payendDate'])]);
        }

        if ($params['org']) {
            $data->andWhere('io.org_id=:org_id', [':org_id' => $params['org']]);
        }


        if ($params['excel']) {
            return $data->orderBy('io.id desc')->asArray()->all();
        } else {
            $pages = new Pagination(['totalCount' => $data->count(), 'pageSize' => '10']);
            $result = $data->orderBy('io.id desc')->offset($pages->offset)->limit($pages->limit)->asArray()->all();
            return ['pages' => $pages, 'data' => $result];
        }
    }

    public static function getInsuredInfo($id, $org_id)
    {
        if (empty($id) || empty($org_id)) {
            throw new UException(ERROR_SYS_PARAMS_CONTENT, ERROR_SYS_PARAMS);
        }
        $insuredInfo = UyeInsuredOrder::find()
            ->select('io.*,o.org_name,oc.name as c_name,ui.*')
            ->from(UyeInsuredOrder::TABLE_NAME . " io")
            ->leftJoin(UyeOrg::TABLE_NAME . " o", "o.id=io.org_id")
            ->leftJoin(UyeOrgCourse::TABLE_NAME . " oc", "oc.id=io.c_id")
            ->leftJoin(UyeUserIdentity::TABLE_NAME . " ui", "ui.uid=io.uid")
            ->where('io.id=:id AND io.org_id=:org_id', [':id' => $id, ":org_id" => $org_id])
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

    public static function refusePay($id, $org_id)
    {
        if (empty($id) || empty($org_id)) {
            return false;
        }

        $insuredOrder = UyeInsuredOrder::findOne($id)->getAttributes();

        if (empty($insuredOrder)) {
            throw new UException(ERROR_INSURED_NOT_EXISTS_CONTENT, ERROR_INSURED_NOT_EXISTS);
        }

        if ($insuredOrder['org_id'] != $org_id) {
            throw new UException(ERROR_INSURED_NOT_EXISTS_CONTENT, ERROR_INSURED_NOT_ORG);
        }

        if ($insuredOrder['insured_status'] != INSURED_STATUS_VERIFY_PASS) {
            throw new UException(ERROR_INSURED_NOT_STATUS_CONTENT, ERROR_INSURED_NOT_STATUS);
        }

        $update = [
            'insured_status' => INSURED_STATUS_VERIFY_REFUSE
        ];
        UyeInsuredOrder::_update($id, $update);
        UyeInsuredLog::_addLog($id, $insuredOrder['insured_order'], $insuredOrder['insured_status'], INSURED_STATUS_VERIFY_REFUSE, \Yii::$app->user->getId(), json_encode($update), "机构拒绝投保");
        return true;
    }
}
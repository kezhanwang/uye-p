<?php
/**
 * Created by PhpStorm.
 * User: wangyi
 * Date: 2017/10/23
 * Time: 上午11:44
 */

namespace e\models\service;


use common\models\ar\UyeAreas;
use common\models\ar\UyeInsuredLog;
use common\models\ar\UyeInsuredOrder;
use common\models\ar\UyeInsuredWater;
use common\models\ar\UyeOrg;
use common\models\ar\UyeOrgCourse;
use common\models\ar\UyeUser;
use common\models\ar\UyeUserContact;
use common\models\ar\UyeUserExperience;
use common\models\ar\UyeUserExperienceList;
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

        if (is_numeric($params['insured_status'])) {
            $data->andWhere('io.insured_status=:insured_status', [':insured_status' => $params['insured_status']]);
        } else if (is_array($params['insured_status'])) {
            $data->andWhere('io.insured_status IN (' . implode(',', $params['insured_status']) . ')');
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

        $data->andWhere('io.org_id=:org_id', [':org_id' => $org_id]);


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

        $expre = UyeUserExperience::findOne($insuredInfo['uid'])->getAttributes();
        $workExpre = UyeUserExperienceList::find()
            ->select('*')
            ->from(UyeUserExperienceList::TABLE_NAME)
            ->where('uid=:uid AND type=:type AND status=:status', [':uid' => $insuredInfo['uid'], ':type' => UyeUserExperienceList::TYPE_WORK, ':status' => UyeUserExperienceList::STATUS_ON])
            ->asArray()->all();
        $studyExpre = UyeUserExperienceList::find()
            ->select('*')
            ->from(UyeUserExperienceList::TABLE_NAME)
            ->where('uid=:uid AND type=:type AND status=:status', [':uid' => $insuredInfo['uid'], ':type' => UyeUserExperienceList::TYPE_STUDY, ':status' => UyeUserExperienceList::STATUS_ON])
            ->asArray()->all();

        $log = UyeInsuredLog::find()
            ->select('*')
            ->from(UyeInsuredLog::TABLE_NAME)
            ->where("insured_id=:insured_id", [':insured_id' => $insuredInfo['id']])
            ->asArray()->all();

        $contact = UyeUserContact::findOne($insuredInfo['uid'])->getAttributes();
        $contact['address'] = '';
        if ($contact['home_area']) {
            $area = UyeAreas::findOne($contact['home_area'])->getAttributes();
            $contact['address'] = str_replace(',', '', $area['joinname']);
        }
        return [
            'insured_order' => $insuredInfo,
            'mobile' => $mobileArr,
            'expre' => $expre,
            'workExpre' => $workExpre,
            'studyExpre' => $studyExpre,
            'contact' => $contact,
            'log' => $log
        ];
    }

    public static function refusePay($id, $org_id)
    {
        if (empty($id) || empty($org_id)) {
            throw new UException(ERROR_SYS_PARAMS_CONTENT, ERROR_SYS_PARAMS);
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

    public static function pay($id, $org_id)
    {
        if (empty($id) || empty($org_id)) {
            throw new UException(ERROR_SYS_PARAMS_CONTENT, ERROR_SYS_PARAMS);
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
            'insured_status' => INSURED_STATUS_PAY,
            'payment_time' => time(),
            'payment_method' => UyeInsuredOrder::PAYMENT_METHOD_ORG
        ];
        UyeInsuredOrder::_update($id, $update);
        UyeInsuredLog::_addLog($id, $insuredOrder['insured_order'], $insuredOrder['insured_status'], INSURED_STATUS_PAY, \Yii::$app->user->getId(), json_encode($update), "机构支付，进入培训中");
        $water = [
            'uid' => \Yii::$app->user->getId(),
            'user_type' => UyeInsuredWater::USER_TYPE_ORG,
            'insured_id' => $insuredOrder['id'],
            'pay_amount' => $insuredOrder['premium_amount'],
            'pay_source' => UyeInsuredWater::PAY_SOURCE_OFFLINE,
            'pay_status' => UyeInsuredWater::PAY_STATUS_SUCCESS,
            'pay_time' => time(),
        ];
        UyeInsuredWater::_add($water);
        return true;
    }
}
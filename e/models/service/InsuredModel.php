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
use components\UException;
use yii\web\NotFoundHttpException;

class InsuredModel
{
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
}
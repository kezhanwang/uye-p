<?php
/**
 * Created by PhpStorm.
 * User: wangyi
 * Date: 2017/10/23
 * Time: 上午10:41
 */

namespace backend\models\service;


use common\models\ar\UyeInsuredOrder;
use common\models\ar\UyeOrg;
use common\models\ar\UyeOrgCourse;
use common\models\ar\UyeUserIdentity;
use yii\web\NotFoundHttpException;

class InsuredModel
{
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
}
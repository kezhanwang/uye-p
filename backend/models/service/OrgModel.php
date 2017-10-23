<?php
/**
 * Created by PhpStorm.
 * User: wangyi
 * Date: 2017/10/23
 * Time: 上午10:57
 */

namespace backend\models\service;


use common\models\ar\UyeOrg;
use common\models\ar\UyeOrgInfo;
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
}
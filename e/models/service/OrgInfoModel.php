<?php
/**
 * Created by PhpStorm.
 * User: wangyi
 * Date: 2017/10/24
 * Time: 下午4:03
 */

namespace e\models\service;


use common\models\ar\UyeOrg;
use yii\web\NotFoundHttpException;

class OrgInfoModel
{
    public static function getOrgInfoList($org_id)
    {
        $orgInfo = UyeOrg::findOne($org_id)->getAttributes();
        if (empty($orgInfo)) {
            throw new NotFoundHttpException(ERROR_ORG_NOT_EXISTS_CONTENT, ERROR_ORG_NOT_EXISTS);
        }
        $query = UyeOrg::find()->select('*')->from(UyeOrg::TABLE_NAME);
        if ($orgInfo['id'] != $orgInfo['parent_id'] && $orgInfo['parent_id'] > 0) {
            $organizes = $query->where('parent_id=:id', [':id' => $orgInfo['parent_id']])->asArray()->all();
        } else {
            $organizes = $query->where('parent_id=:id', [':id' => $org_id])->asArray()->all();
        }

        return $organizes;
    }
}
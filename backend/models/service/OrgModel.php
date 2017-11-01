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
        $orgKey = ['org_name', 'org_short_name', 'org_type', 'is_employment', 'employment_rate', 'is_high_salary', 'business'];

        $org = [];

        foreach ($orgKey as $item) {
            if (!array_key_exists($item, $params)) {
                throw new UException(ERROR_SYS_PARAMS_CONTENT . ":" . $item, ERROR_SYS_PARAMS);
            } else {
                $org[$item] = $params[$item];
            }
        }

        $org['status'] = UyeOrg::STATUS_SAVE;
        $orgInfo = UyeOrg::_add($org);

        $params['org_id'] = $orgInfo['id'];

        $result = UyeOrgInfo::_addOrgInfo($params);

        return $orgInfo;
    }
}
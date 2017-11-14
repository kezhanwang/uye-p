<?php
/**
 * Created by PhpStorm.
 * User: wangyi
 * Date: 2017/11/14
 * Time: 上午11:38
 */


namespace backend\models\service;


use common\models\ar\UyeERole;
use common\models\ar\UyeEUser;
use common\models\ar\UyeEUserRole;
use common\models\ar\UyeOrg;
use components\CheckUtil;
use yii\data\Pagination;

class EuserModel
{

    public static function getEuserList($params = [])
    {
        $query = UyeEUser::find()
            ->select('e.*,o.org_name,er.role_id,r.role_name')
            ->from(UyeEUser::TABLE_NAME . ' e')
            ->leftJoin(UyeOrg::TABLE_NAME . ' o', 'o.id=e.org_id')
            ->leftJoin(UyeEUserRole::TABLE_NAME . ' er', 'er.uid=e.id')
            ->leftJoin(UyeERole::TABLE_NAME . ' r', 'r.id=er.role_id');

        if ($params['phone'] && CheckUtil::checkPhone($params['phone'])) {
            $query->andWhere('e.username=:username', [':username' => $params['phone']]);
        }

        if ($params['org'] && is_numeric($params['org'])) {
            $query->andWhere('e.org_id=:org_id', [':org_id' => $params['org']]);
        } else if ($params['org']) {
            $query->andWhere("o.org_name LIKE '%{$params['org']}%'");
        }

        if ($params['role_id'] && is_numeric($params['role_id'])) {
            $query->andWhere('er.role_id=:role_id', [':role_id' => $params['role_id']]);
        }

        $pages = new Pagination(['totalCount' => $query->count(), 'pageSize' => '10']);
        $euserList = $query->orderBy('id desc,org_id asc')->offset($pages->offset)->limit($pages->limit)->asArray()->all();
        return [
            'pages' => $pages,
            'users' => $euserList
        ];
    }
}
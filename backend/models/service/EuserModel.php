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
use components\UException;
use yii\base\NotSupportedException;
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

    public static function registerEUser($params = [])
    {
        if (empty($params)) {
            throw new NotSupportedException(ERROR_SYS_PARAMS_CONTENT);
        }

        $check = UyeEUser::find()->select('*')->from(UyeEUser::TABLE_NAME)->where('username=:username', [':username' => $params['username']])->asArray()->all();
        if (!empty($check)) {
            throw new UException('已经添加改手机号管理员，请勿重复添加', ERROR_SYS_PARAMS);
        }

        $org = UyeOrg::getOrgById($params['org_id'], null, null, true);
        if (empty($org)) {
            throw new UException(ERROR_ORG_NO_EXISTS_CONTENT, ERROR_ORG_NO_EXISTS);
        }

        $user = new UyeEUser();
        $user->setIsNewRecord(true);
        $user->username = $params['username'];
        $user->email = $params['email'];
        $user->org_id = $params['org_id'];
        $user->setPassword($params['password']);
        $user->generateAuthKey();

        if (!$user->save()) {
            UException::dealAR($user);
        }
        $userInfo = $user->getAttributes();
        $role = new UyeEUserRole();
        $role->setIsNewRecord(true);
        $role->uid = $userInfo['id'];
        $role->role_id = $params['role_id'];
        if (!$role->save()) {
            UException::dealAR($role);
        }
        return true;
    }

    public static function updateUserInfo($params = [])
    {
        if (empty($params)) {
            throw new NotSupportedException(ERROR_SYS_PARAMS_CONTENT);
        }

        $updateUser = [];
        if ($params['email'] && CheckUtil::checkEmail($params['email'])) {
            $updateUser['email'] = $params['email'];
        }

        if (CheckUtil::isPWD($params['password'])) {
            $updateUser['password'] = $params['password'];
        }

        $userInfo = UyeEUser::findOne(['id' => $params['id']]);
        $userInfo->email = $updateUser['email'];
        $userInfo->setPassword($updateUser['password']);
        if (!$userInfo->save()) {
            UException::dealAR($userInfo);
        }

        if ($params['role_id'] && is_numeric($params['role_id'])) {
            $role = UyeEUserRole::findOne(['uid' => $params['id']]);
            $role->role_id = $params['role_id'];
            $role->updated_time = time();
            if (!$role->save()) {
                UException::dealAR($role);
            }
        }

        return true;
    }


}
<?php
/**
 * Created by PhpStorm.
 * User: wangyi
 * Date: 2017/10/26
 * Time: 下午3:39
 */

namespace backend\models\service;


use common\models\ar\UyeAdminUser;
use components\UException;
use yii\data\Pagination;

class AuserModel
{
    public static function getAdminUserList($params)
    {
        $query = UyeAdminUser::find()
            ->select('*')
            ->from(UyeAdminUser::TABLE_NAME);

        $pages = new Pagination(['totalCount' => $query->count(), 'pageSize' => '10']);
        $adminUser = $query->orderBy('id desc')->offset($pages->offset)->limit($pages->limit)->asArray()->all();
        return [
            'pages' => $pages,
            'users' => $adminUser
        ];
    }

    public static function registerAdminUser($params)
    {
        if (!empty($params)) {
            $user = new UyeAdminUser();
            $user->username = $params['phone'];
            $user->email = $params['email'];
            $user->realname = $params['username'];
            $user->phone = $params['phone'];
            $user->setPassword($params['password']);
            $user->generateAuthKey();
            if (!$user->save()) {
                var_dump($user);exit;
                UException::dealAR($user);
            }
            return $user->getAttributes();
        } else {
            throw new UException();
        }
    }
}
<?php
/**
 * Created by PhpStorm.
 * User: wangyi
 * Date: 2017/10/23
 * Time: 下午6:12
 */

namespace e\components;


use common\models\ar\UyeERole;
use common\models\ar\UyeEUser;
use common\models\ar\UyeEUserRole;
use GuzzleHttp\Exception\BadResponseException;
use yii\helpers\ArrayHelper;

class RbacUtil
{
    public static function checkUserRight($uid)
    {
        $userInfo = self::getUserInfo($uid);
        $userRole = self::getUserRole($uid);

        return ArrayHelper::merge($userInfo, $userRole);
    }

    public static function getUserInfo($uid)
    {
        $userInfo = UyeEUser::find()
            ->select('*')
            ->from(UyeEUser::TABLE_NAME)
            ->where('id=:id AND status=:status', [':id' => $uid, ':status' => UyeEUser::STATUS_ACTIVE])
            ->asArray()
            ->one();
        if (empty($userInfo)) {
            throw new BadResponseException("未查询到用户信息");
        }
        return $userInfo;
    }

    public static function getUserRole($uid)
    {
        $userRole = UyeEUserRole::find()
            ->select('*')
            ->from(UyeEUserRole::TABLE_NAME . " eur")
            ->leftJoin(UyeERole::TABLE_NAME . " er", 'er.id=eur.role_id')
            ->where('eur.uid=:uid', [':uid' => $uid])
            ->asArray()
            ->one();

        if (empty($userRole)) {
            throw new BadResponseException("未查询到用户角色");
        }
        return $userRole;

    }
}
<?php
/**
 *
 * @authors wangyi
 * @date    2017-10-28 20:36:52
 * @version $Id$
 */

namespace backend\models\service;

use common\models\ar\UyeAreas;
use common\models\ar\UyeUser;
use common\models\ar\UyeUserContact;
use common\models\ar\UyeUserIdentity;
use common\models\ar\UyeUserMobile;
use yii\data\Pagination;

class UserModel
{
    public static function getUserList($params = [])
    {
        $query = UyeUser::find()
            ->select('u.*,ui.full_name')
            ->from(UyeUser::TABLE_NAME . " u")
            ->leftJoin(UyeUserIdentity::TABLE_NAME . " ui", "ui.uid=u.uid");

        if ($params['user']) {
            if (is_numeric($params['uid'])) {
                $query->andWhere('u.uid=:uid', [':uid' => $params['user']]);
            } else {
                $query->andWhere("ui.full_name LIKE '%{$params['user']}%'");
            }
        }

        if ($params['phone']) {
            $query->andWhere('u.phone=:phone', [':phone' => $params[':phone']]);
        }

        $pages = new Pagination(['totalCount' => $query->count(), 'pageSize' => '10']);
        $insuredList = $query->orderBy('u.uid desc')->offset($pages->offset)->limit($pages->limit)->asArray()->all();
        return [
            'pages' => $pages,
            'users' => $insuredList
        ];
    }

    public static function getUserInfo($uid)
    {
        $user = UyeUser::findOne($uid)->getAttributes();
        $userIdentity = UyeUserIdentity::findOne($uid)->getAttributes();
        $userMobile = UyeUserMobile::findOne($uid)->getAttributes();
        $userContact = UyeUserContact::findOne($uid)->getAttributes();

        if (!empty($userIdentity['home_area'])) {
            $info = UyeAreas::getAreas(-1, $userIdentity['home_area']);
            $userIdentity['home'] = str_replace(',', '', $info[0]['joinname']);
        } else {
            $userIdentity['home'] = '';
        }

        if ($userMobile) {
            $mobileArr = json_decode($userMobile['list'], true);
        } else {
            $mobileArr = [];
        }
        return [
            'user' => $user,
            'identity' => $userIdentity,
            'mobile' => $mobileArr,
            'contact' => $userContact,
        ];
    }

}
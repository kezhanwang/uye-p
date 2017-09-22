<?php
/**
 * Created by PhpStorm.
 * User: wangyi
 * Date: 2017/9/22
 * Time: 下午5:53
 */

namespace backend\models;


use common\models\ar\UyeUser;
use components\CheckUtil;

class Users
{
    public static function getUserList($uid = null, $phone = null, $beginDate = null, $endDate = null, $page = 1)
    {
        $params = [];
        if (is_numeric($uid)) {
            $params[] = ['condition' => 'uid=:uid', 'params' => [':uid' => $uid]];
        }

        if ($phone && CheckUtil::phone($phone)) {
            $params[] = ['condition' => 'phone=:phone', 'params' => [':phone' => $phone]];
        }

        if ($beginDate) {
            $params[] = ['condition' => 'created_time>=:begin', 'params' => [':begin' => strtotime($beginDate)]];
        }

        if ($endDate) {
            $params[] = ['condition' => 'created_time>=:end', 'params' => [':end' => strtotime($endDate)]];
        }

        $count = UyeUser::find()->select("count(*) count")->where('1=1');
        if (!empty($params)) {
            foreach ($params as $param) {
                $count->andWhere($param['condition'], $param['params']);
            }
        }
        $count = $count->asArray()->one();


        $lists = UyeUser::find()->select("*")->where('1=1');
        if (!empty($params)) {
            foreach ($params as $param) {
                $lists->andWhere($param['condition'], $param['params']);
            }
        }
        $userInfos = $lists->orderBy('uid desc')->limit(10)->offset(($page - 1) * 10)->asArray()->all();


    }
}
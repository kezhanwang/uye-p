<?php
/**
 * Created by PhpStorm.
 * User: wangyi
 * Date: 2017/10/25
 * Time: 上午11:38
 */

namespace e\models\service;


use common\models\ar\UyeEUser;
use common\models\ar\UyeInsuredWater;
use common\models\ar\UyeOrg;
use components\UException;
use yii\data\Pagination;
use yii\db\Expression;

class WaterModel
{
    public static function getWaterGroupDate($params, $org_id)
    {
        if (empty($org_id)) {
            throw new UException();
        }

        $query = UyeInsuredWater::find()
            ->select(new Expression('FROM_UNIXTIME(created_time,"%Y-%m-%d") AS date, COUNT(id) AS total, SUM(pay_amount) AS pay_amount'))
            ->from(UyeInsuredWater::TABLE_NAME)
            ->where('org_id=:org_id AND pay_status=:pay_status AND user_type=:user_type', [':org_id' => $org_id, ':pay_status' => UyeInsuredWater::PAY_STATUS_SUCCESS, ':user_type' => UyeInsuredWater::USER_TYPE_ORG]);

        if ($params['beginDate']) {
            $query->andWhere('created_time>=:begin', [':begin' => strtotime($params['beginDate'] . " 00:00:00")]);
        }

        if ($params['endDate']) {
            $query->andWhere('created_time<=:end', [':end' => strtotime($params['endDate'] . " 23:59:59")]);
        }

        if ($params['pay_source']) {
            $query->andWhere('pay_source=:pay_source', [':pay_source' => $params['pay_source']]);
        }

        $query->groupBy(new Expression('FROM_UNIXTIME(created_time,"%Y-%m-%d")'));
        $pages = new Pagination(['totalCount' => $query->count(), 'pageSize' => '10']);
        $result = $query->orderBy(new Expression('FROM_UNIXTIME(created_time,"%Y-%m-%d") DESC'))->offset($pages->offset)->limit($pages->limit)->asArray()->all();
        foreach ($result as &$item) {
            $item['detail'] = self::getWaterInfoByDate($item['date'], $org_id);
        }

        return ['pages' => $pages, 'data' => $result];

    }

    public static function getWaterInfoList($params, $org_id)
    {
        $query = UyeInsuredWater::find()
            ->select(new Expression('iw.*,o.org_name,eu.username'))
            ->from(UyeInsuredWater::TABLE_NAME . " iw")
            ->leftJoin(UyeOrg::TABLE_NAME . " o", "o.id=iw.org_id")
            ->leftJoin(UyeEUser::TABLE_NAME . " eu", "eu.id=iw.uid")
            ->where('iw.org_id=:org_id AND iw.pay_status=:pay_status AND iw.user_type=:user_type ', [':org_id' => $org_id, ':pay_status' => UyeInsuredWater::PAY_STATUS_SUCCESS, ':user_type' => UyeInsuredWater::USER_TYPE_ORG]);

        if ($params['beginDate']) {
            $query->andWhere('iw.created_time>=:begin', [':begin' => strtotime($params['beginDate'] . " 00:00:00")]);
        }

        if ($params['endDate']) {
            $query->andWhere('iw.created_time<=:end', [':end' => strtotime($params['endDate'] . " 23:59:59")]);
        }

        $data = $query->orderBy('iw.created_time DESC')
            ->asArray()
            ->all();
        if (empty($data)) {
            return [];
        } else {
            return $data;
        }
    }

    public static function getWaterInfoByDate($date, $org_id)
    {
        $beginTime = strtotime($date . " 00:00:00");
        $endTime = strtotime($date . " 23:59:59");
        $data = UyeInsuredWater::find()
            ->select(new Expression('iw.*,o.org_name,eu.username'))
            ->from(UyeInsuredWater::TABLE_NAME . " iw")
            ->leftJoin(UyeOrg::TABLE_NAME . " o", "o.id=iw.org_id")
            ->leftJoin(UyeEUser::TABLE_NAME . " eu", "eu.id=iw.uid")
            ->where('iw.org_id=:org_id AND iw.pay_status=:pay_status AND iw.user_type=:user_type ', [':org_id' => $org_id, ':pay_status' => UyeInsuredWater::PAY_STATUS_SUCCESS, ':user_type' => UyeInsuredWater::USER_TYPE_ORG])
            ->andWhere("iw.created_time BETWEEN :begin AND :end", [':begin' => $beginTime, ':end' => $endTime])
            ->orderBy('iw.created_time DESC')
            ->asArray()
            ->all();
        if (empty($data)) {
            return [];
        } else {
            return $data;
        }
    }
}
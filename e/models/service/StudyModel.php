<?php
/**
 * Created by PhpStorm.
 * User: wangyi
 * Date: 2017/12/7
 * Time: 上午11:52
 */

namespace e\models\service;


use common\models\ar\UyeInsuredLog;
use common\models\ar\UyeInsuredOrder;
use components\UException;

class StudyModel
{
    /**
     * 毕业操作
     * @param $insured_id
     * @param $uid
     * @param $org_id
     * @return bool
     * @throws UException
     */
    public static function graduation($insured_id, $uid, $org_id)
    {
        if (is_null($insured_id) || !is_numeric($insured_id)) {
            throw new UException();
        }

        $insured = UyeInsuredOrder::getOrderByID($insured_id);
        if (empty($insured)) {
            throw new UException(ERROR_INSURED_NOT_EXISTS_CONTENT, ERROR_INSURED_NOT_EXISTS);
        }

        if ($insured['insured_status'] != INSURED_STATUS_STUDYING) {
            throw new UException();
        }

        if ($insured['org_id'] != $org_id) {
            throw new UException();
        }

        $date = date('Y-m-d');
        $updateInsured = [
            'insured_status' => INSURED_STATUS_JOB_SEARCH,
            'graduation_date' => $date,
            'work_start' => $date,
            'work_end' => date('Y-m-d', strtotime('+180 days', time()))
        ];

        try {
            UyeInsuredOrder::_update($insured['id'], $updateInsured);
            UyeInsuredLog::_addLog($insured['id'], $insured['insured_order'], $insured['insured_status'], INSURED_STATUS_JOB_SEARCH, $uid, json_encode($updateInsured), INSURED_STATUS_JOB_SEARCH_CONTENT_ORG);
            return true;
        } catch (UException $exception) {
            throw new UException($exception->getMessage(), $exception->getCode());
        }
    }
}
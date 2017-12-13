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
use common\models\ar\UyeInsuredStudy;
use components\UException;

class StudyModel
{
    /**
     * 毕业操作
     * @param $insured_id
     * @param $uid
     * @param $org_id
     * @param $addStudyLog
     * @return bool
     * @throws UException
     */
    public static function graduation($insured_id, $uid, $org_id, $addStudyLog = true)
    {
        if (is_null($insured_id) || !is_numeric($insured_id)) {
            throw new UException(ERROR_SYS_PARAMS_CONTENT, ERROR_SYS_PARAMS);
        }

        $insured = UyeInsuredOrder::getOrderByID($insured_id);
        if (empty($insured)) {
            throw new UException(ERROR_INSURED_NOT_EXISTS_CONTENT, ERROR_INSURED_NOT_EXISTS);
        }

        if ($insured['insured_status'] != INSURED_STATUS_STUDYING) {
            throw new UException(ERROR_INSURED_NOT_STATUS_CONTENT, ERROR_INSURED_NOT_STATUS);
        }

        if ($insured['org_id'] != $org_id) {
            throw new UException(ERROR_INSURED_NOT_ORG_CONTENT, ERROR_INSURED_NOT_ORG);
        }

        $date = date('Y-m-d');
        $updateInsured = [
            'insured_status' => INSURED_STATUS_JOB_SEARCH,
            'graduation_date' => $date,
            'work_start' => $date,
            'work_end' => date('Y-m-d', strtotime('+180 days', time()))
        ];

        if ($addStudyLog) {
            $addInfo = [
                'insured_id' => $insured['id'],
                'insured_order' => $insured['insured_order'],
                'add_type' => UyeInsuredStudy::ADD_TYPE_ORG,
                'status' => UyeInsuredStudy::STUDY_STATUS_GRADUATION,
            ];
            UyeInsuredStudy::_add($addInfo);
        }

        try {
            UyeInsuredOrder::_update($insured['id'], $updateInsured);
            UyeInsuredLog::_addLog($insured['id'], $insured['insured_order'], $insured['insured_status'], INSURED_STATUS_JOB_SEARCH, $uid, json_encode($updateInsured), INSURED_STATUS_JOB_SEARCH_CONTENT_ORG);
            return true;
        } catch (UException $exception) {
            throw new UException($exception->getMessage(), $exception->getCode());
        }
    }

    public static function addStudyList($params = [], $uid, $org_id)
    {
        if (!array_key_exists('id', $params) || !is_numeric($params['id'])) {
            throw new UException(ERROR_SYS_PARAMS_CONTENT, ERROR_SYS_PARAMS);
        }

        $insured = UyeInsuredOrder::getOrderByID($params['id']);
        if (empty($insured)) {
            throw new UException(ERROR_INSURED_NOT_EXISTS_CONTENT, ERROR_INSURED_NOT_EXISTS);
        }

        if ($insured['insured_status'] != INSURED_STATUS_STUDYING) {
            throw new UException(ERROR_INSURED_NOT_STATUS_CONTENT, ERROR_INSURED_NOT_STATUS);
        }

        if ($insured['org_id'] != $org_id) {
            throw new UException(ERROR_INSURED_NOT_ORG_CONTENT, ERROR_INSURED_NOT_ORG);
        }

        //处理时间
        if ($params['status'] == UyeInsuredStudy::STUDY_STATUS_TRAINING) {
            list($day, $month, $year) = explode('/', $params['start']);
            $startDate = $year . '-' . $month . '-' . $day;
            list($day, $month, $year) = explode('/', $params['end']);
            $endDate = $year . '-' . $month . '-' . $day;
        } else {
            $startDate = '';
            $endDate = '';
        }

        //将图片处理为json串存储
        $pic = explode(',', $params['pic']);
        foreach ($pic as $key => $item) {
            if (empty($item)) {
                unset($pic[$key]);
            }
        }
        $pic = json_encode(array_values($pic));

        $addInfo = [
            'insured_id' => $insured['id'],
            'insured_order' => $insured['insured_order'],
            'add_type' => UyeInsuredStudy::ADD_TYPE_ORG,
            'status' => $params['status'],
            'start_date' => $startDate,
            'end_date' => $endDate,
            'ranking' => $params['ranking'],
            'fraction' => $params['fraction'],
            'remark' => $params['remark'],
            'pic' => $pic
        ];

        try {
            UyeInsuredStudy::_add($addInfo);
            if ($params['status'] == UyeInsuredStudy::STUDY_STATUS_GRADUATION) {
                self::graduation($insured['id'], $uid, $org_id, false);
            } else if ($params['status'] == UyeInsuredStudy::STUDY_STATUS_TRAINING) {
                $update = [
                    'class_end' => $endDate,
                    'work_start' => date('Y-m-d', strtotime('+1 days', strtotime($endDate))),
                    'work_end' => date('Y-m-d', strtotime('+180 days', strtotime($endDate)))
                ];
                UyeInsuredOrder::_update($insured['id'], $update);
                UyeInsuredLog::_addLog($insured['id'], $insured['insured_order'], $insured['insured_status'], $insured['insured_status'], $uid, json_encode($update), INSURED_STATUS_STUDYING_CONTENT_ORG);
            }
            return true;
        } catch (UException $exception) {
            throw new UException($exception->getCode(), $exception->getMessage());
        }
    }
}
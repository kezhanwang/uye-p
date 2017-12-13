<?php
/**
 * Created by PhpStorm.
 * User: wangyi
 * Date: 2017/12/13
 * Time: 下午2:03
 */

namespace e\models\service;


use common\models\ar\UyeInsuredLog;
use common\models\ar\UyeInsuredOrder;
use common\models\ar\UyeInsuredWork;
use components\UException;

class JobModel
{
    public static function addJobInfo($params = [], $uid, $org_id)
    {
        if (!array_key_exists('id', $params) || !is_numeric($params['id'])) {
            throw new UException(ERROR_SYS_PARAMS_CONTENT, ERROR_SYS_PARAMS);
        }

        $insured = UyeInsuredOrder::getOrderByID($params['id']);
        if (empty($insured)) {
            throw new UException(ERROR_INSURED_NOT_EXISTS_CONTENT, ERROR_INSURED_NOT_EXISTS);
        }

        if ($insured['insured_status'] != INSURED_STATUS_JOB_SEARCH) {
            throw new UException(ERROR_INSURED_NOT_STATUS_CONTENT, ERROR_INSURED_NOT_STATUS);
        }

        if ($insured['org_id'] != $org_id) {
            throw new UException(ERROR_INSURED_NOT_ORG_CONTENT, ERROR_INSURED_NOT_ORG);
        }

        //将图片处理为json串存储
        $pic = explode(',', $params['pic']);
        foreach ($pic as $key => $item) {
            if (empty($item)) {
                unset($pic[$key]);
            }
        }
        $pic = json_encode(array_values($pic));

        list($day, $month, $year) = explode('/', $params['date']);
        $date = $year . '-' . $month . '-' . $day;

        $addInfo = [
            'insured_id' => $insured['id'],
            'insured_order' => $insured['insured_order'],
            'date' => $date,
            'work_province' => $params['work_province'],
            'work_city' => $params['work_city'],
            'work_area' => $params['work_area'],
            'work_address' => $params['work_address'],
            'work_name' => $params['work_name'],
            'position' => $params['position'],
            'monthly_income' => $params['monthly_income'],
            'add_type' => UyeInsuredWork::ADD_TYPE_ORG,
            'pic_json' => $pic,
        ];

        try {
            UyeInsuredWork::_add($addInfo);
            if ($params['is_hiring'] == UyeInsuredWork::IS_HIRING_SUCCESS) {
                $update = [
                    'insured_status' => INSURED_STATUS_WORK,
                ];
                UyeInsuredOrder::_update($insured['id'], $update);
                UyeInsuredLog::_addLog($insured['id'], $insured['insured_order'], $insured['insured_status'], INSURED_STATUS_WORK, $uid, json_encode($update), '');
            }
            return true;
        } catch (UException $exception) {
            throw new UException($exception->getMessage(), $exception->getCode());
        }
    }
}
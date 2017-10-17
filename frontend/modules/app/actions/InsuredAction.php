<?php
/**
 * Created by PhpStorm.
 * User: wangyi
 * Date: 2017/10/17
 * Time: 上午10:58
 */

namespace app\modules\app\actions;


use app\modules\app\components\AppAction;
use common\models\ar\UyeInsuredOrder;
use common\models\ar\UyeOrg;
use components\Output;
use components\UException;
use frontend\models\DataBus;

class InsuredAction extends AppAction
{
    public function run()
    {
        try {
            $request = \Yii::$app->request;
            $params = $request->getBodyParams();

            $checkParams = [
                'org_id' => 'int',
                'c_id' => 'int',
                'tuition' => 'int',
                'class' => 'string',
                'class_start' => 'date',
                'class_end' => 'date',
                'course_consultant' => 'string',
                'group_pic' => 'string',
                'training_pic' => 'json',
                'phoneid' => 'string',
                'map_lng' => 'int',
                'map_lat' => 'int',
                'insured_type' => 'int'
            ];

            foreach ($checkParams as $key => $checkParam) {
                if (!array_key_exists($key, $params) || empty($params[$key])) {
                    throw new UException(ERROR_SYS_PARAMS_CONTENT, ERROR_SYS_PARAMS);
                }

                if ($checkParam == 'ini' && !is_numeric($params[$key])) {
                    throw new UException(ERROR_SYS_PARAMS_CONTENT, ERROR_SYS_PARAMS);
                }

                if ($checkParam == 'json') {
                    $tmpArr = json_decode($params[$key], true);
                    if (!is_array($tmpArr) || empty($tmpArr)) {
                        throw new UException(ERROR_SYS_PARAMS_CONTENT, ERROR_SYS_PARAMS);
                    }
                }
            }

            $orgInfo = UyeOrg::getOrgById($params['org_id']);
            if (empty($orgInfo)) {
                throw new UException();
            }

            if ($params['insured_type'] == UyeInsuredOrder::INSURED_TYPE_EMPLOYMENT && $orgInfo['is_employment'] != UyeOrg::IS_EMPLOYMENT_SUPPORT) {
                throw new UException();
            }

            if ($params['insured_type'] == UyeInsuredOrder::INSURED_TYPE_SALARY && $orgInfo['is_high_salary'] != UyeOrg::IS_HIGH_SALARY_SUPPORT) {
                throw new UException();
            }

            $add = $params;
            $add['uid'] = DataBus::get('uid');
            $add['insured_order'] = Output::orderid();
            $add['insured_status'] = INSURED_STATUS_CREATE;

            UyeInsuredOrder::_add($add);
        } catch (UException $exception) {
            Output::err($exception->getCode(), $exception->getMessage());
        }
    }
}
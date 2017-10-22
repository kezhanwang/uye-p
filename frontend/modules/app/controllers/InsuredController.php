<?php
/**
 * Created by PhpStorm.
 * User: wangyi
 * Date: 2017/10/13
 * Time: 上午10:58
 */

namespace app\modules\app\controllers;


use app\modules\app\components\AppController;
use app\modules\app\models\InsuredModel;
use components\Output;
use components\UException;
use frontend\models\DataBus;

class InsuredController extends AppController
{
    public function init()
    {
        parent::init(); // TODO: Change the autogenerated stub
    }

    public function actions()
    {
        return [
            'submit' => [
                'class' => 'app\modules\app\actions\InsuredAction'
            ],
        ];
    }

    public function actionConfig()
    {
        try {
            $org_id = $this->getParams('org_id');
            if (empty($org_id) || !is_numeric($org_id)) {
                throw new UException(ERROR_SYS_PARAMS_CONTENT, ERROR_SYS_PARAMS);
            }

            $organize = InsuredModel::getOrganize($org_id);
            $courses = InsuredModel::getCourses($org_id);
            $templateData = [
                'contract' => DOMAIN_WWW . '/html/contract/insured_contract.html',
                'organize' => $organize,
                'courses' => $courses
            ];
            Output::info(SUCCESS, SUCCESS_CONTENT, $templateData);
        } catch (UException $exception) {
            Output::err($exception->getCode(), $exception->getMessage());
        }
    }
}
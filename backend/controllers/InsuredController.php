<?php
/**
 * Created by PhpStorm.
 * User: wangyi
 * Date: 2017/10/22
 * Time: 下午5:32
 */

namespace backend\controllers;


use backend\components\UAdminController;
use backend\models\search\InsuredSearch;
use backend\models\service\InsuredModel;
use common\models\ar\UyeInsuredOrder;

class InsuredController extends UAdminController
{
    public function actionIndex()
    {
        $data = InsuredModel::getInsuredList(\Yii::$app->request->queryParams);
        return $this->render('index', $data);
    }

    public function actionView($id)
    {

        $info = InsuredModel::getInsuredInfo($id);
        return $this->render('view', $info);
    }

    public function actionUpdate()
    {

    }

    public function actionAuthlist()
    {
        $params = \Yii::$app->request->queryParams;
        $params['insured_status'] = INSURED_STATUS_CREATE;

        $data = InsuredModel::getInsuredList(\Yii::$app->request->queryParams);
        return $this->render('authlist', $data);
    }

    public function actionWater()
    {
        $data = InsuredModel::getWaterList(\Yii::$app->request->queryParams);
        return $this->render('water', $data);
    }
}
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

class InsuredController extends UAdminController
{
    public function actionIndex()
    {
        $searchModel = new InsuredSearch();
        $dataProvider = $searchModel->search(\Yii::$app->request->queryParams);
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionView($id)
    {

        $info = InsuredModel::getInsuredInfo($id);
        var_dump($info);

        return $this->render('view', $info);
    }

    public function actionUpdate()
    {

    }
}
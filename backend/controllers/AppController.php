<?php
/**
 * Created by PhpStorm.
 * User: wangyi
 * Date: 2017/10/19
 * Time: 下午3:41
 */

namespace backend\controllers;

use common\models\ar\UyeAppVersion;
use common\models\search\UyeAppVersionSearch;
use Yii;
use backend\components\UAdminController;
use yii\filters\VerbFilter;
use yii\web\NotFoundHttpException;

class AppController extends UAdminController
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    public function actionIndex()
    {

    }

    public function actionVersion()
    {
        $searchModel = new UyeAppVersionSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('version', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionVview($id)
    {
        return $this->render('vview', [
            'model' => $this->findModel($id),
        ]);
    }


    public function actionVcreate()
    {
        $model = new UyeAppVersion();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('vcreate', [
                'model' => $model,
            ]);
        }
    }

    public function actionVupdate($id)
    {
        $model = $this->findUyeAppVersionModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('vupdate', [
                'model' => $model,
            ]);
        }
    }


    public function actionVdelete($id)
    {
        $this->findUyeAppVersionModel($id)->delete();

        return $this->redirect(['version']);
    }


    protected function findUyeAppVersionModel($id)
    {
        if (($model = UyeAppVersion::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
<?php

namespace backend\controllers;

use backend\components\UAdminController;
use common\models\ar\UyeOrg;
use common\models\ar\UyeOrgInfo;
use common\models\search\UyeOrgSearch;
use Yii;

use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * OrgController implements the CRUD actions for UyeOrg model.
 */
class OrgController extends UAdminController
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
//                    'delete' => ['POST', 'GET'],
                ],
            ],
        ];
    }

    /**
     * Lists all UyeOrg models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new UyeOrgSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->pagination->defaultPageSize = 10;
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single UyeOrg model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
            'info_model' => $this->findInfoModel($id),
        ]);
    }

    /**
     * Creates a new UyeOrg model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new UyeOrg();
        $infoModel = new UyeOrgInfo();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
                'infoModel' => $infoModel,
            ]);
        }
    }

    /**
     * Updates an existing UyeOrg model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing UyeOrg model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $info = [
            'is_delete' => 1,
            'is_shelf' => UyeOrg::IS_SHELF_OFF,
            'is_employment' => UyeOrg::IS_EMPLOYMENT_NOT_SUPPORT,
            'is_high_salary' => UyeOrg::IS_HIGH_SALARY_NOT_SUPPORT
        ];

        UyeOrg::_update($id, $info);

        return $this->redirect(['index']);
    }

    /**
     * Finds the UyeOrg model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return UyeOrg the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = UyeOrg::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    protected function findInfoModel($org_id)
    {
        if (($model = UyeOrgInfo::findOne($org_id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}

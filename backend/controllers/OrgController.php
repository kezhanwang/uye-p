<?php

namespace backend\controllers;

use backend\components\AOutPut;
use backend\components\UAdminController;
use backend\models\service\OrgModel;
use common\models\ar\UyeAdminUser;
use common\models\ar\UyeCategory;
use common\models\ar\UyeOrg;
use common\models\ar\UyeOrgCourse;
use common\models\ar\UyeOrgInfo;
use common\models\search\UyeOrgSearch;
use components\PicUtil;
use components\UException;
use GuzzleHttp\Exception\BadResponseException;
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
        $courses = UyeOrgCourse::getCoursesListByOrgID($id);
        return $this->render('view', [
            'model' => $this->findModel($id),
            'info_model' => $this->findInfoModel($id),
            'courses' => $courses,
        ]);
    }

    /**
     * Creates a new UyeOrg model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $type = $this->getParams('type', '');
        $parent = $this->getParams('parent', '');
        if ($type && $type == 'create') {
            $params = $_POST;
            if (empty($params)) {
                throw new UException(ERROR_SYS_PARAMS_CONTENT, ERROR_SYS_PARAMS);
            }
            $result = OrgModel::createOrg($params);
            return $this->redirect(['view', 'id' => $result['id']]);
        } else {
            $org = [];
            if ($parent && is_numeric($parent)) {
                $org = UyeOrg::findOne($parent)->getAttributes();
                if (empty($org)) {
                    throw new NotFoundHttpException(ERROR_ORG_NO_EXISTS_CONTENT, ERROR_ORG_NO_EXISTS);
                }
            }
            $category = UyeCategory::find()->asArray()->all();
            $business = UyeAdminUser::find()->select('*')->from(UyeAdminUser::TABLE_NAME)->where('business=:business',
                [':business' => 1])->asArray()->all();
            return $this->render('create', ['org' => $org, 'category' => $category, 'business' => $business]);
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
        $info = OrgModel::getOrgInfo($id);

        $category = UyeCategory::find()->asArray()->all();
        $business = UyeAdminUser::find()->select('*')->from(UyeAdminUser::TABLE_NAME)->where('business=:business',
            [':business' => 1])->asArray()->all();
        $area = OrgModel::getArea($info['province'], $info['city']);
        return $this->render('update',
            ['info' => $info, 'category' => $category, 'business' => $business, 'area' => $area]);
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

    public function actionUpload()
    {
        $pic_res = PicUtil::uploadPic(0, $to_thumb_keys = array(), $fileInfo, array('logo'));
        $pic_res_url = DOMAIN_IMAGE . $pic_res['logo'];
        echo json_encode($pic_res_url);
    }

    public function actionAuth()
    {
        try {
            $id = $this->getParams('id');
            $status = $this->getParams('status');
            OrgModel::auth($id, $status);
            AOutPut::info(SUCCESS, SUCCESS_CONTENT);
        } catch (UException $exception) {
            AOutPut::err($exception->getCode(), $exception->getMessage());
        }
    }

    public function actionShelf()
    {
        try {
            $id = $this->getParams('id');
            $shelf = $this->getParams('shelf');
            OrgModel::shelf($id, $shelf);
            AOutPut::info(SUCCESS, SUCCESS_CONTENT . ":已更新搜索");
        } catch (UException $exception) {
            AOutPut::err($exception->getCode(), $exception->getMessage());
        }
    }

    public function actionCourse()
    {
        $type = $this->getParams('type');
        if ($type == 'create') {
            $params = $_POST;
            if (empty($params)) {
                throw new UException(ERROR_SYS_PARAMS_CONTENT, ERROR_SYS_PARAMS);
            }
            $result = OrgModel::createCourse($params);
            return $this->redirect(['view', 'id' => $params['org_id']]);
        } else {
            $org_id = $this->getParams('org_id');
            if (empty($org_id) || !is_numeric($org_id)) {
                throw new NotFoundHttpException(ERROR_SYS_PARAMS_CONTENT);
            }

            $org_info = UyeOrg::findOne($org_id)->getAttributes();
            if (empty($org_info)) {
                throw new NotFoundHttpException(ERROR_ORG_NO_EXISTS_CONTENT);
            }

            return $this->render('course', ['org' => $org_info]);
        }
    }

}

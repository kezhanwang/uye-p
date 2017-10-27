<?php
/**
 * Created by PhpStorm.
 * User: wangyi
 * Date: 2017/10/26
 * Time: 下午3:32
 */

namespace backend\controllers;

use backend\models\service\AuserModel;
use Yii;
use backend\components\UAdminController;

class AuserController extends UAdminController
{
    public function actionIndex()
    {
        $data = AuserModel::getAdminUserList(Yii::$app->request->queryParams);
        return $this->render('index', $data);
    }

    public function actionRegister()
    {
        $params = Yii::$app->request->queryParams;
        if (!empty($params)) {
            AuserModel::registerAdminUser($params);
            return $this->redirect('/auser/index');
        } else {
            return $this->render('register');
        }
    }

}
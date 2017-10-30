<?php
/**
 * Created by PhpStorm.
 * User: wangyi
 * Date: 2017/9/22
 * Time: 下午5:25
 */

namespace backend\controllers;

use backend\components\UAdminController;
use Yii;
use backend\models\service\UserModel;

class UserController extends UAdminController
{
    /**
     * 用户列表
     * @return mixed
     */
    public function actionIndex()
    {

        $data = UserModel::getUserList(Yii::$app->request->queryParams);
        return $this->render('index', $data);
    }

    /**
     * Displays a single UyeUser model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view');
    }

}
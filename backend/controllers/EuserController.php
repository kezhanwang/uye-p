<?php
/**
 * Created by PhpStorm.
 * User: wangyi
 * Date: 2017/11/14
 * Time: 上午11:36
 */

namespace backend\controllers;

use common\models\ar\UyeERole;
use Yii;
use backend\components\UAdminController;
use backend\models\service\EuserModel;


/**
 * 机构管理员
 * Class EuserController
 * @package controllers
 */
class EuserController extends UAdminController
{
    public function actionIndex()
    {
        $data = EuserModel::getEuserList(Yii::$app->request->queryParams);
        $data['role'] = UyeERole::find()->asArray()->all();
        return $this->render('index', $data);
    }

    public function actionRegister()
    {
        $params = Yii::$app->request->post();
        if (!empty($params)) {
            EuserModel::registerEUser($params);
            return $this->redirect('/euser/index');
        } else {
            $template = [
                'role' => UyeERole::find()->asArray()->all(),
            ];
            return $this->render('register', $template);
        }
    }


}
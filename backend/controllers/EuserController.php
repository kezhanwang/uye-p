<?php
/**
 * Created by PhpStorm.
 * User: wangyi
 * Date: 2017/11/14
 * Time: 上午11:36
 */

namespace backend\controllers;

use common\models\ar\UyeERole;
use common\models\ar\UyeEUser;
use common\models\ar\UyeEUserRole;
use common\models\ar\UyeOrg;
use Yii;
use backend\components\UAdminController;
use backend\models\service\EuserModel;
use yii\base\NotSupportedException;


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

    public function actionUpdate()
    {
        $type = $this->getParams('type');
        $id = $this->getParams('id');
        if ($type && $type == 'update') {
            $params = $_POST;
            EuserModel::updateUserInfo($params);
            return $this->redirect('/euser/index');
        } else {
            $userInfo = UyeEUser::findIdentity($id);
            $org = UyeOrg::getOrgById($userInfo['org_id']);
            $rbac = UyeEUserRole::findOne(['uid' => $id])->getAttributes();
            $template = [
                'role' => UyeERole::find()->asArray()->all(),
                'user' => $userInfo,
                'org' => $org,
                'rbac' => $rbac
            ];
            return $this->render('update', $template);
        }
    }

    public function actionDelete($id)
    {
        if (!is_numeric($id) || is_null($id)) {
            throw new NotSupportedException(ERROR_USER_INFO_NO_EXISTS_CONTENT);
        }

        $user = UyeEUser::findOne(['id' => $id]);
        $user->status = UyeEUser::STATUS_DELETED;
        $user->save();
        return $this->redirect('/euser/index');
    }


}
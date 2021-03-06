<?php
/**
 * Created by PhpStorm.
 * User: wangyi
 * Date: 2017/9/18
 * Time: 下午5:32
 */

namespace frontend\controllers;


use components\CheckUtil;
use frontend\models\UyeUserModel;
use Yii;
use components\Output;
use components\UException;
use frontend\components\UController;

class UserController extends UController
{
    public function init()
    {
        parent::init(); // TODO: Change the autogenerated stub
        $this->checkLogin();
    }


    public function actionUpdatePassword()
    {
        try {
            $request = Yii::$app->request;
            $oldPassword = $request->isPost ? $request->post('old') : $request->get('old');
            $newPassword = $request->isPost ? $request->post('new') : $request->get('new');

            if (!CheckUtil::isPWD($oldPassword) || !CheckUtil::isPWD($newPassword)) {
                throw new UException(ERROR_PASSWORD_FORMAT_CONTENT, ERROR_PASSWORD_FORMAT);
            }

            if ($newPassword === $oldPassword) {
                throw new UException(ERROR_CHANGE_PASSWORD_SAME_CONTENT, ERROR_CHANGE_PASSWORD_SAME);
            }

            UyeUserModel::changePassword($this->uid, $oldPassword, $newPassword);
            Output::info(SUCCESS, SUCCESS_CONTENT);
        } catch (\Exception $exception) {
            Output::err($exception->getCode(), $exception->getMessage());
        }
    }
}
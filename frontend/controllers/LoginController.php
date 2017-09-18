<?php

namespace app\controllers;


use components\CheckUtil;
use components\Output;
use components\UException;
use components\VerifyCodeUtil;
use frontend\components\UController;
use frontend\models\UyeUserModel;
use yii\db\Exception;

class LoginController extends UController
{
    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionLogin()
    {

    }

    /**
     * @throws UException
     */
    public function actionRegister()
    {
        try {
            $method = $_SERVER['REQUEST_METHOD'];
            if (strtolower($method) != 'post') {
                throw new UException();
            }
            $request = \Yii::$app->request;
            $phone = $request->post('phone');
            $vcode = $request->post('vcode');
            $phone_code = $request->post('phone_code');
            $password = $request->post('password');

            if (!CheckUtil::phone($phone)) {
                throw new UException(ERROR_PHONE_FORMAT_CONTENT, ERROR_PHONE_FORMAT);
            }

            if (!VerifyCodeUtil::checkCode($vcode)) {
                throw new UException(ERROR_VCODE_CONTENT, ERROR_VCODE);
            }

            if ($phone_code) {
                throw new UException('', '');
            }
            UyeUserModel::register($phone, $password);
            UyeUserModel::login($phone, $password);
            Output::info(SUCCESS, SUCCESS_CONTENT);
        } catch (Exception $exception) {
            Output::err($exception->getCode(), $exception->getMessage());
        }
    }

}

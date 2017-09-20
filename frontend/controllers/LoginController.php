<?php

namespace frontend\controllers;


use components\CheckUtil;
use components\Output;
use components\UException;
use components\VerifyCodeUtil;
use frontend\components\UController;
use frontend\models\UyeUserModel;

class LoginController extends UController
{
    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionLogin()
    {
        try {
            $method = $_SERVER['REQUEST_METHOD'];
            if (strtolower($method) != 'post') {
                throw new UException();
            }

            $phone = \Yii::$app->request->post('phone');
            $password = \Yii::$app->request->post('password');

            UyeUserModel::login($phone, $password);

            Output::info(SUCCESS, '登录成功');
        } catch (\Exception $exception) {
            Output::err($exception->getCode(), $exception->getMessage());
        }
    }

    public function actionLoginphone()
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


            UyeUserModel::loginByPhoneCode($phone, $phone_code);

            Output::info(SUCCESS, '登录成功');
        } catch (\Exception $exception) {
            Output::err($exception->getCode(), $exception->getMessage());
        }
    }

    /**
     * @throws UException
     */
    public function actionRegister()
    {
        try {
            $request = \Yii::$app->request;
            if ($request->isPost) {
                $phone = $request->post('phone');
                $vcode = $request->post('vcode');
                $phone_code = $request->post('phone_code');
                $password = $request->post('password');
            } else {
                throw new UException('请求方式错误');
            }

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
        } catch (\Exception $exception) {
            Output::err($exception->getCode(), $exception->getMessage());
        }
    }

}

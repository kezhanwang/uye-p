<?php

namespace frontend\controllers;


use components\CheckUtil;
use components\Output;
use components\UException;
use frontend\components\UController;
use frontend\models\UyeUserModel;
use Yii;

class LoginController extends UController
{
    public function actionIndex()
    {
        return $this->render('index');
    }

    /**
     * 普通密码登陆
     */
    public function actionLogin()
    {
        try {
            $request = Yii::$app->request;
            $phone = $request->post() ? $request->post('phone') : $request->get('phone');
            $password = $request->post() ? $request->post('password') : $request->get('password');
            UyeUserModel::login($phone, $password);
            Output::info(SUCCESS, '登录成功', array(), $this->token());
        } catch (\Exception $exception) {
            Output::err($exception->getCode(), $exception->getMessage(), array(), $this->uid, $this->token());
        }
    }

    /**
     * 短信验证码登录
     */
    public function actionLoginphone()
    {
        try {
            $request = Yii::$app->request;
            $phone = $request->post() ? $request->post('phone') : $request->get('phone');
            $code = $request->post() ? $request->post('code') : $request->get('code');
            UyeUserModel::loginByPhoneCode($phone, $code);
            Output::info(SUCCESS, '登录成功', array(), $this->token());
        } catch (\Exception $exception) {
            Output::err($exception->getCode(), $exception->getMessage(), array(), $this->uid, $this->token());
        }
    }

    /**
     * 注册
     */
    public function actionRegister()
    {
        try {
            $request = Yii::$app->request;
            $phone = $request->post() ? $request->post('phone') : $request->get('phone');
            $code = $request->post() ? $request->post('code') : $request->get('code');
            $password = $request->post() ? $request->post('password') : $request->get('password');
            if (!CheckUtil::phone($phone)) {
                throw new UException(ERROR_PHONE_FORMAT_CONTENT, ERROR_PHONE_FORMAT);
            }
            if ($code) {
                throw new UException('', '');
            }

            if (!CheckUtil::isPWD($password)) {
                throw new UException(ERROR_PASSWORD_FORMAT_CONTENT, ERROR_PASSWORD_FORMAT);
            }
            UyeUserModel::register($phone, $password);
            UyeUserModel::login($phone, $password);
            Output::info(SUCCESS, SUCCESS_CONTENT, array(), $this->token());
        } catch (\Exception $exception) {
            Output::err($exception->getCode(), $exception->getMessage(), array(), $this->uid, $this->token());
        }
    }

}

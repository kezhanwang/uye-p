<?php

namespace frontend\controllers;


use components\CheckUtil;
use components\CookieUtil;
use components\Output;
use components\SmsUtil;
use components\UException;
use frontend\components\UController;
use frontend\models\DataBus;
use frontend\models\UyeUserModel;
use Yii;

class LoginController extends UController
{
    private $ip = null;

    public function init()
    {
        parent::init(); // TODO: Change the autogenerated stub
        $this->ip = Yii::$app->request->getUserIP();
    }

    private function checkIsLogin()
    {
        if ($this->isLogin()) {
            if ($this->isMobile) {
                Output::err(ERROR_LOGIN_ING, ERROR_LOGIN_ING_CONTENT);
            } else {
                Output::err(ERROR_LOGIN_ING, ERROR_LOGIN_ING_CONTENT);
            }
        }
    }

    /**
     * 普通密码登陆
     */
    public function actionLogin()
    {
        try {
            $this->checkIsLogin();
            $request = Yii::$app->request;
            $phone = $request->post() ? $request->post('phone') : $request->get('phone');
            $password = $request->post() ? $request->post('password') : $request->get('password');
            if (!CheckUtil::checkPhone($phone)) {
                throw new UException(ERROR_PHONE_FORMAT_CONTENT, ERROR_PHONE_FORMAT);
            }
            if (!CheckUtil::isPWD($password)) {
                throw new UException(ERROR_PASSWORD_FORMAT_CONTENT, ERROR_PASSWORD_FORMAT);
            }
            $phoneid = $request->post() ? $request->post('phoneid', '') : $request->get('phoneid', '');
            $userInfo = UyeUserModel::login($phone, $password, $phoneid);
            Yii::info('[' . __CLASS__ . '][' . __FUNCTION__ . '][' . __LINE__ . '][phone]:' . $phone . '[password]:' . $password . '[phoneid]:' . $phoneid, 'login');
            $userInfo['cookie'] = $this->getCookie($userInfo);
            Output::info(SUCCESS, '登录成功', $userInfo);
        } catch (\Exception $exception) {
            Output::err($exception->getCode(), $exception->getMessage());
        }
    }

    /**
     * 短信验证码登录
     */
    public function actionLoginphone()
    {
        try {
            $this->checkIsLogin();
            $request = Yii::$app->request;
            $phone = $request->post() ? $request->post('phone') : $request->get('phone');
            $code = $request->post() ? $request->post('code') : $request->get('code');
            $phoneid = $request->post() ? $request->post('phoneid', '') : $request->get('phoneid', '');
            if (!CheckUtil::checkPhone($phone)) {
                throw new UException(ERROR_PHONE_FORMAT_CONTENT, ERROR_PHONE_FORMAT);
            }

            SmsUtil::checkVerifyCode($phone, $this->ip, $code);
            Yii::info('[' . __CLASS__ . '][' . __FUNCTION__ . '][' . __LINE__ . '][phone]:' . $phone . '[code]:' . $code . '[phoneid]:' . $phoneid, 'login');
            $userInfo = UyeUserModel::loginByPhoneCode($phone, $phoneid);
            $userInfo['cookie'] = $this->getCookie($userInfo);
            Output::info(SUCCESS, '登录成功', $userInfo);
        } catch (\Exception $exception) {
            Output::err($exception->getCode(), $exception->getMessage());
        }
    }

    /**
     * 注册
     */
    public function actionRegister()
    {
        try {
            $this->checkIsLogin();
            $request = Yii::$app->request;
            $phone = $request->post() ? $request->post('phone') : $request->get('phone');
            $code = $request->post() ? $request->post('code') : $request->get('code');
            $password = $request->post() ? $request->post('password') : $request->get('password');
            $phoneid = $request->post() ? $request->post('phoneid', '') : $request->get('phoneid', '');
            Yii::info('[' . __CLASS__ . '][' . __FUNCTION__ . '][' . __LINE__ . '][phone]:' . $phone . '[password]:' . $password . '[code]:' . $code . '[phoneid]:' . $phoneid, 'login');
            if (!CheckUtil::phone($phone)) {
                throw new UException(ERROR_PHONE_FORMAT_CONTENT, ERROR_PHONE_FORMAT);
            }
            if (!CheckUtil::isPWD($password)) {
                throw new UException(ERROR_PASSWORD_FORMAT_CONTENT, ERROR_PASSWORD_FORMAT);
            }

            SmsUtil::checkVerifyCode($phone, $this->ip, $code);

            if (!CheckUtil::isPWD($password)) {
                throw new UException(ERROR_PASSWORD_FORMAT_CONTENT, ERROR_PASSWORD_FORMAT);
            }
            UyeUserModel::register($phone, $password);
            $userInfo = UyeUserModel::login($phone, $password, $phoneid);
            $userInfo['cookie'] = $this->getCookie($userInfo);
            Output::info(SUCCESS, SUCCESS_CONTENT, $userInfo);
        } catch (\Exception $exception) {
            Output::err($exception->getCode(), $exception->getMessage());
        }
    }

    private function getCookie($userInfo = array())
    {
        if (empty($userInfo)) {
            $cookie = ['PHPSESSID' => session_id()];
        } else {
            $strCode = $userInfo['uid'] . "|" . $userInfo['username'] . "|" . $userInfo['phone'] . '|' . CookieUtil::createSafecv();
            if ($this->isMobile) {
                $cookie = ['PHPSESSID' => session_id(), CookieUtil::db_cookiepre . DataBus::COOKIE_KEY => CookieUtil::strCode($strCode)];
            } else {
                CookieUtil::Cookie(DataBus::COOKIE_KEY, CookieUtil::strCode($strCode), strtotime('+1 day'));
                $cookie = ['PHPSESSID' => session_id(), CookieUtil::db_cookiepre . DataBus::COOKIE_KEY => CookieUtil::strCode($strCode)];
            }
        }
        return $cookie;
    }

    public function actionLogout()
    {
        try {
            CookieUtil::Cookie(DataBus::COOKIE_KEY, '', time() - 3600);
            session_start();
            $_SESSION = array();
            if (isset($_COOKIE[session_name()])) {
                setCookie(session_name(), '', time() - 3600, '/');
            }
            session_destroy();
            Output::info(SUCCESS, SUCCESS_CONTENT);
        } catch (UException $exception) {
            Output::err($exception->getCode(), $exception->getMessage());
        }
    }
}

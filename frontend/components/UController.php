<?php

namespace frontend\components;


use components\HttpUtil;
use components\Output;
use components\TokenUtil;
use frontend\models\DataBus;
use yii\web\Controller;
use yii;

class UController extends Controller
{

    public $isMobile = false;
    protected $user;
    protected $uid;
    protected $token;
    protected $newToken;
    protected $requestData;
    protected $key;

    public function init()
    {
        parent::init(); // TODO: Change the autogenerated stub
        $this->enableCsrfValidation = false;
        $this->user = DataBus::get('user');
        $this->uid = DataBus::get('uid');
        DataBus::get('plat') ? $this->isMobile = true : $this->isMobile = false;
//        $this->verification();
//        $this->verifySign();
    }

    public function verification()
    {
        $request = Yii::$app->request;

        if ($this->isMobile) {
            $this->key = $request->isPost ? $request->post('phoneid') : $request->get('phoneid');
        } else {
            $this->key = session_id();
        }
        $requestData = $request->isPost ? $request->post() : $request->get();
        if (!array_key_exists('token', $requestData)) {
            Output::err(ERROR_TOKEN_NO_EXISTS, ERROR_TOKEN_NO_EXISTS_CONTENT);
        }

        $check = TokenUtil::checkToken($this->key, $this->uid, $requestData['token'], DataBus::get('plat'));
        if ($check) {
            $this->token = $requestData['token'];
            $this->newToken = $check;
            $this->requestData = $requestData;
        } else {
            Output::err(ERROR_TOKEN_CHECK_WRONG, ERROR_TOKEN_CHECK_WRONG_CONTENT);
        }
    }

    public function verifySign()
    {
        if (!array_key_exists('sign', $this->requestData)) {
            Output::err(ERROR_SIGN_NO_EXISTS, ERROR_SIGN_NO_EXISTS_CONTENT);
        }

        $sign = $this->requestData['sign'];
        unset($this->requestData['sign']);

        ksort($this->requestData);
        $newSign = sha1($this->requestData, true);
        if ($newSign === $sign) {
            return true;
        } else {
            Output::err(ERROR_SIGN_CHECK_WRONG, ERROR_SIGN_CHECK_WRONG_CONTENT);
        }
    }

    /**
     * 查询当前登录态
     * @return array|mixed
     */
    protected function isLogin()
    {
        return DataBus::get('isLogin');
    }

    /**
     * 检查是否登录,未登录直接返回错误信息
     * @param bool $toLogin
     * @return array|mixed
     */
    protected function checkLogin($toLogin = false)
    {
        if (!$this->isLogin()) {
            if ($toLogin) {
                HttpUtil::goLogin();
            } else {
                Output::err(ERROR_LOGIN_NO, ERROR_LOGIN_NO_CONTENT);
            }
        } else {
            return $this->isLogin();
        }
    }

}
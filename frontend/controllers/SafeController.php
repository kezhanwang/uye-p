<?php
/**
 * Created by PhpStorm.
 * User: wangyi
 * Date: 2017/9/18
 * Time: 上午11:59
 */

namespace frontend\controllers;

use components\CheckUtil;
use components\SmsUtil;
use components\UException;
use frontend\models\DataBus;
use Yii;
use components\Output;
use components\VerifyCodeUtil;
use frontend\components\UController;

class SafeController extends UController
{

    public function actionVcode()
    {
        $request = Yii::$app->request;
        if ($request->isPost) {
            $w = $request->post('w');
            $h = $request->post('h');
        } else if ($request->isGet) {
            $w = $request->get('w');
            $h = $request->get('h');
        }
        try {
            $fileData = VerifyCodeUtil::getCode(null, null, $w, $h, $this->isMobile);
            Output::info(SUCCESS, SUCCESS_CONTENT, ['image' => base64_encode($fileData)], $this->token());
        } catch (\Exception $exception) {
            Output::err($exception->getCode(), $exception->getMessage(), array(), $this->uid, $this->token());
        }
    }

    /**
     * 验证验证码图片是否正确
     */
    public function actionVCodeCheck()
    {
        $request = Yii::$app->request;
        $code = $request->isPost ? $request->post('vcode') : $request->get('vcode');
        try {
            if (empty($code)) {
                throw new UException(ERROR_VCODE_CONTENT, ERROR_VCODE);
            }
            if (!VerifyCodeUtil::checkCode($code)) {
                throw new UException(ERROR_VCODE_CONTENT, ERROR_VCODE);
            }
            Output::info(SUCCESS, SUCCESS_CONTENT, array(), $this->token());
        } catch (\Exception $exception) {
            Output::err($exception->getCode(), $exception->getMessage(), array(), $this->uid, $this->token());
        }
    }


    public function actionGetmsgcode()
    {
        $request = Yii::$app->request;
        $phone = $request->isPost ? $request->post('phone') : $request->get('phone');
        try {
            if (!CheckUtil::phone($phone)) {
                throw new UException(ERROR_PHONE_FORMAT_CONTENT, ERROR_PHONE_FORMAT);
            }

            $result = SmsUtil::sendVerifyCode($phone, Yii::$app->request->getUserIP(), DataBus::get('uid'));

            if (empty($result)) {
                throw new UException(ERROR_PHONE_CODE_CONTENT, ERROR_PHONE_CODE);
            } else {
                Output::info(SUCCESS, SUCCESS_CONTENT, $result, $this->token());
            }
        } catch (\Exception $exception) {
            Output::err($exception->getCode(), $exception->getMessage(), array(), $this->uid, $this->token());
        }

    }
}
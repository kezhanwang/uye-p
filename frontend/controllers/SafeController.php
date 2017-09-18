<?php
/**
 * Created by PhpStorm.
 * User: wangyi
 * Date: 2017/9/18
 * Time: 上午11:59
 */

namespace frontend\controllers;

use components\CheckUtil;
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
            $isMobile = DataBus::get('plat') == 4 ? false : true;
            $fileData = VerifyCodeUtil::getCode(null, null, $w, $h, $isMobile);
            Output::info(SUCCESS, SUCCESS_CONTENT, ['image' => base64_encode($fileData)]);
        } catch (\Exception $exception) {
            Output::err($exception->getCode(), $exception->getMessage());
        }
    }

    /**
     * 验证验证码图片是否正确
     */
    public function actionVCodeCheck()
    {
        $request = Yii::$app->request;
        if ($request->isPost) {
            $code = $request->post('vcode');
        } else if ($request->isGet) {
            $code = $request->get('vcode');
        }
        try {
            if (empty($code)) {
                throw new UException("请输入验证码");
            }
            if (!VerifyCodeUtil::checkCode($code)) {
                throw new UException('图片验证码输错啦!请重新输入。');
            }
            Output::info(SUCCESS, SUCCESS_CONTENT);
        } catch (\Exception $exception) {
            Output::err($exception->getCode(), $exception->getMessage());
        }
    }


    public function actiongetmescode()
    {
        $request = Yii::$app->request;
        if ($request->isPost) {
            $phone = $request->post('phone');
            $vcode = $request->post('vcode');
        } else if ($request->isGet) {
            $phone = $request->get('phone');
            $vcode = $request->get('vcode');
        } else {
            $phone = '';
            $vcode = '';
        }

        try {
            $result = array();
            if (!CheckUtil::phone($phone)) {
                throw new UException(ERROR_PHONE_FORMAT_CONTENT, ERROR_PHONE_FORMAT);
            }
            if (!empty($code) && !preg_match("/^[0-9]{4}$/", $code)) {
                throw new UException(ERROR_VCODE_CONTENT, ERROR_VCODE);
            }

            $vcodeCheckRes = VerifyCodeUtil::checkCode($vcode);
            if ($vcodeCheckRes) {
//            $code = SmsUtil::createCode();
//            if (ARCode::insert($phone, $code)) {
//                $res = SmsUtil::sendVerify($phone, $code, DataBus::get('uid'));
//                if ($res == 0) {
//                    $result = array('result' => 0);
//                }
//            }
            } else {
                throw new UException(ERROR_VCODE_CONTENT . ":未验证通过", ERROR_VCODE);
            }

            if (empty($result)) {
                throw new UException(ERROR_PHONE_CODE_CONTENT, ERROR_PHONE_CODE);
            } else {
                Output::info(SUCCESS, SUCCESS_CONTENT, $result);
            }
        } catch (\Exception $exception) {
            Output::err($exception->getCode(), $exception->getMessage());
        }

    }
}
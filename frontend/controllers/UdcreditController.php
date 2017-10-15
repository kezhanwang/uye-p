<?php
/**
 * Created by PhpStorm.
 * User: wangyi
 * Date: 2017/10/12
 * Time: 下午4:00
 */

namespace frontend\controllers;


use common\models\ar\UyeUserAuth;
use common\models\udcredit\NotifyHandle;
use common\models\udcredit\UdcreditNotify;
use components\Output;
use components\UException;
use frontend\components\UController;
use frontend\models\DataBus;

class UdcreditController extends UController
{
    const USER_ID_SUFFIX = 'UYE_PERSON_';

    const SAFE_MODE_HIGH = 0;
    const SAFE_MODE_MIDDLE = 1;
    const SAFE_MODE_LOW = 2;

    public function init()
    {
        parent::init(); // TODO: Change the autogenerated stub
    }

    public function actionIndex()
    {
//        if ($this->isMobile) {
//            $this->checkLogin();
//        } else {
//            $this->checkLogin(true);
//        }

        try {
            $uid = DataBus::get('uid');

            $config = \Yii::$app->params['udcredit'];
            if (empty($config)) {
                throw new UException(ERROR_SECRET_CONFIG_NO_EXISTS_CONTENT, ERROR_SECRET_CONFIG_NO_EXISTS);
            }
            $order = Output::orderid();

            UyeUserAuth::_add(['uid' => $uid, 'order' => $order]);

            $data = [
                'key' => $config['merchant_key'],
                'order' => $order,
                'user_id' => self::USER_ID_SUFFIX . $uid,
                'notify_url' => '',
                'safe_mode' => self::SAFE_MODE_HIGH,
            ];
            Output::info(SUCCESS, SUCCESS_CONTENT, $data);
        } catch (UException $exception) {
            Output::err($exception->getCode(), $exception->getMessage());
        }
    }

    public function actionUdcreditNotify()
    {
        try {
            $methodType = strtolower($_SERVER['REQUEST_METHOD']);
            if ($methodType != 'post') {
                throw new UException("请求方式异常");
            }
            $post_data = file_get_contents('php://input');
            // 验证数据和签名
            $params = json_decode($post_data, true);
            if (!is_array($params)) {
                throw new UException('数据格式异常');
            }
            $data = UdcreditNotify::Init($params); //为了测试所以不效验签名

            // 验证支付结果处理逻辑
            $result = NotifyHandle::NotifyHandle($data);
            if ($result) {
                UdcreditNotify::ReplyNotify(true);
            } else {
                UdcreditNotify::ReplyNotify(false);
            }
        } catch (UException $e) {
            $respData = array('code' => '0', 'message' => $e->getMessage());
            echo json_encode($respData);
        }
    }

    public function actionAuthorize()
    {
        try {
            $methodType = strtolower($_SERVER['REQUEST_METHOD']);
            if ($methodType != 'post') {
                throw new UException("请求方式异常");
            }
            $post_data = file_get_contents('php://input');
            $params = json_decode($post_data, true);
            if (!is_array($params)) {
                throw new UException('数据格式异常');
            }
            $type = \Yii::$app->request->getParam('authorize');
            if (in_array($type, array(1, 2, 3))) {
                NotifyHandle::addUserAuthorize($params);
            }
            UdcreditNotify::ReplyNotify(true);
        } catch (UException $e) {
            $respData = array('code' => '0', 'message' => $e->getMessage());
            echo json_encode($respData);
        }
    }
}
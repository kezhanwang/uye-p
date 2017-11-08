<?php
/**
 * Created by PhpStorm.
 * User: wangyi
 * Date: 2017/9/20
 * Time: 下午7:45
 */

namespace frontend\controllers;


use common\models\ar\UyeAreas;
use common\models\service\SimgService;
use components\CookieUtil;
use components\Output;
use components\PicUtil;
use components\RedisUtil;
use components\UException;
use frontend\components\UController;
use frontend\models\DataBus;

class CommonController extends UController
{

    /**
     * 获取400电话
     */
    public function actionGet400()
    {
        Output::info(SUCCESS, SUCCESS_CONTENT, array('company_phone' => \Yii::$app->params['company_phone']));
    }

    /**
     * 上传文件
     */
    public function actionUpload()
    {
        try {
            \Yii::info(__LINE__ . ':' . __FUNCTION__ . $this->uid . ':' . DataBus::get('plat') . " upload pic :" . var_export($_FILES,
                    true), 'upload_file');
            $fileInfo = [];
            $ret = PicUtil::uploadPic(PicUtil::SECRET_ADMIN, [], $fileInfo, [], $this->uid);
            $ret = PicUtil::getUrls($ret, PicUtil::SECRET_ADMIN);
            SimgService::addSimgInfo($ret, DataBus::get('uid'));
            \Yii::info(__LINE__ . ':' . __FUNCTION__ . $this->uid . ':' . DataBus::get('plat') . " upload pic return url:" . var_export($ret,
                    true), 'upload_file');
            Output::info(SUCCESS, SUCCESS_CONTENT, $ret);
        } catch (UException $exception) {
            \Yii::error(__LINE__ . ':' . __FUNCTION__ . $this->uid . ':' . DataBus::get('plat') . " upload pic error:" . $exception->getMessage(),
                'upload_file');
            Output::err($exception->getCode(), $exception->getMessage());
        }
    }

    public function actionProvince()
    {
        try {
            $redis = RedisUtil::getInstance();
            $key = "UYE_GET_PROVINCE";
            $data = $redis->get($key);
            if ($data) {
                $list = json_decode($data, true);
            } else {
                $list = UyeAreas::getAreas(0);

                foreach ($list as &$item) {
                    unset($item['parentid']);
                    unset($item['joinname']);
                    list($item['letter'], $item['name']) = explode('-', $item['name']);
                }

                $redis->set($key, json_encode($list));
            }
            Output::info(SUCCESS, SUCCESS_CONTENT, $list);
        } catch (UException $exception) {
            Output::err($exception->getCode(), $exception->getMessage());
        }
    }

    public function actionCity()
    {
        try {
            $request = \Yii::$app->request;
            $province = $request->isPost ? $request->post("province") : $request->get("province");
            if (empty($province) || !is_numeric($province)) {
                throw new UException(ERROR_SYS_PARAMS_CONTENT, ERROR_SYS_PARAMS);
            }

            $redis = RedisUtil::getInstance();
            $key = "UYE_GET_CITY_BY_PROVINCE_" . $province;
            $data = $redis->get($key);
            if ($data) {
                $list = json_decode($data, true);
            } else {
                $list = UyeAreas::getAreas($province);
                foreach ($list as &$item) {
                    unset($item['parentid']);
                    unset($item['joinname']);
                }

                $redis->set($key, json_encode($list));
            }
            Output::info(SUCCESS, SUCCESS_CONTENT, $list);
        } catch (UException $exception) {
            Output::err($exception->getCode(), $exception->getMessage());
        }
    }

    public function actionArea()
    {
        try {
            $request = \Yii::$app->request;
            $city = $request->isPost ? $request->post("city") : $request->get("city");
            if (empty($city) || !is_numeric($city)) {
                throw new UException(ERROR_SYS_PARAMS_CONTENT, ERROR_SYS_PARAMS);
            }

            $redis = RedisUtil::getInstance();
            $key = "UYE_GET_AREA_BY_CITY_" . $city;
            $data = $redis->get($key);
            if ($data) {
                $list = json_decode($data, true);
            } else {
                $list = UyeAreas::getAreas($city);
                foreach ($list as &$item) {
                    unset($item['parentid']);
                    $item['joinname'] = str_replace(',', '', $item['joinname']);
                }
                $redis->set($key, json_encode($list));
            }
            Output::info(SUCCESS, SUCCESS_CONTENT, $list);
        } catch (UException $exception) {
            Output::err($exception->getCode(), $exception->getMessage());
        }
    }

    public function actionTest()
    {
        $cookieValue = "BglWVlZSUh0FUwcaGxISVFIDBUVXU1dTVlMBVAcBA0R KlB4fGtRIA==";
        $cookieValue = str_replace(' ', '+', $cookieValue);
        $userInfo = CookieUtil::strCode($cookieValue, 'DECODE');
        var_dump($userInfo);
    }
}
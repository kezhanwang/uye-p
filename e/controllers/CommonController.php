<?php
/**
 * Created by PhpStorm.
 * User: wangyi
 * Date: 2017/12/12
 * Time: 下午2:06
 */

namespace e\controllers;


use common\models\ar\UyeAreas;
use common\models\ar\UyeInsuredOrder;
use common\models\service\SimgService;
use components\PicUtil;
use components\RedisUtil;
use components\UException;
use e\components\EController;
use e\components\EOutput;

class CommonController extends EController
{
    public function init()
    {
        parent::init(); // TODO: Change the autogenerated stub
        $this->enableCsrfValidation = false;
    }

    /**
     * 上传
     */
    public function actionUpload()
    {

        try {
            $id = $this->getParams('id');
            $insuredInfo = UyeInsuredOrder::getOrderByID($id);
            if (empty($insuredInfo)) {
                throw new UException(ERROR_INSURED_NOT_EXISTS_CONTENT, ERROR_INSURED_NOT_EXISTS);
            }

            if ($this->org_id != $insuredInfo['org_id']) {
                throw new UException();
            }

            $fileInfo = [];
            $ret = PicUtil::uploadPic(PicUtil::SECRET_ADMIN, [], $fileInfo, [], $insuredInfo['uid']);
            $ret = PicUtil::getUrls($ret, PicUtil::SECRET_ADMIN);
            SimgService::addSimgInfo($ret, $insuredInfo['uid']);
            EOutput::info(SUCCESS, SUCCESS_CONTENT, $ret);
        } catch (UException $exception) {
            EOutput::err($exception->getCode(), $exception->getMessage());
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
            EOutput::info(SUCCESS, SUCCESS_CONTENT, $list);
        } catch (UException $exception) {
            EOutput::err($exception->getCode(), $exception->getMessage());
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
            EOutput::info(SUCCESS, SUCCESS_CONTENT, $list);
        } catch (UException $exception) {
            EOutput::err($exception->getCode(), $exception->getMessage());
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
            EOutput::info(SUCCESS, SUCCESS_CONTENT, $list);
        } catch (UException $exception) {
            EOutput::err($exception->getCode(), $exception->getMessage());
        }
    }
}
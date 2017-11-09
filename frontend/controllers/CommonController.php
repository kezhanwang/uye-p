<?php
/**
 * Created by PhpStorm.
 * User: wangyi
 * Date: 2017/9/20
 * Time: 下午7:45
 */

namespace frontend\controllers;

require_once PATH_BASE . DIRECTORY_SEPARATOR . ".." . DIRECTORY_SEPARATOR . "vendor" . DIRECTORY_SEPARATOR . "autoload.php";

use common\models\ar\UyeAppVersion;
use common\models\ar\UyeAreas;
use common\models\ar\UyeDownloadLog;
use common\models\service\SimgService;
use components\HttpUtil;
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


    const DOWNLOAD_IOS_VER = '1.0.0';
    const DOWNLOAD_IOS = 'https://itunes.apple.com/app/id1026601319?mt=8';

    const DOWNLOAD_ANDROID_VER = '1.0.0';
    const DOWNLOAD_ANDROID = 'http://www.bjzhongteng.com/html/release_uye_v10.apk';

    public function actionDownload()
    {
        $detect = new \Mobile_Detect();
        if ($detect->isMobile()) {
            if ($detect->is('IOS')) {
                $plat = 1;
            } else {
                if ($detect->is('AndroidOS')) {
                    $plat = 2;
                } else {
                    $plat = 3;
                }
            }
        } else {
            $plat = 2;
        }

        $isWX = (isset($_SERVER['HTTP_USER_AGENT']) && stripos($_SERVER['HTTP_USER_AGENT'], 'micromessenger') !== false ? true : false);
        $new_version = UyeAppVersion::getVersion('', $plat);
        $ver = $new_version[0]['version'] ? $new_version[0]['version'] : self::DOWNLOAD_ANDROID_VER;
        if ($isWX) {
            $url = DOMAIN_WWW . '/html/wx_download/wx_download.html';
            HttpUtil::goUrl($url);
        } else if ($plat == 1) {
            $url = self::DOWNLOAD_IOS;
        } else if ($plat == 2 || $plat == 3) {
            $url = $new_version[0]['url'];
        } else {
            $url = $new_version[0]['url'];
        }
        UyeDownloadLog::_add([
            'uid' => $this->uid,
            'name' => 1,
            'type' => $plat,
            'ua' => $_SERVER['HTTP_USER_AGENT'],
            'ip' => ip2long(\Yii::$app->request->getUserIP()),
            'version' => $ver,
        ]);
        HttpUtil::goUrl($url);
    }


}
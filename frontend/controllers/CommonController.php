<?php
/**
 * Created by PhpStorm.
 * User: wangyi
 * Date: 2017/9/20
 * Time: 下午7:45
 */

namespace frontend\controllers;


use common\models\ar\UyeAppVersion;
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

    public function actionDownload()
    {
        $type = 4;

        //可以由参数控制下载哪个
        if (isset($_GET['type']) && $_GET['type'] == 1) {
            $type = 1;
            $this->isIOS = true;
            $this->isAndroid = false;
        } else if (isset($_GET['type']) && $_GET['type'] == 2) {
            $type = 2;
            $this->isAndroid = true;
            $this->isIOS = false;
        }

        if ($type != 4) {
            $new_version = UyeAppVersion::getVersion('', $type);
        } else {
            $new_version = UyeAppVersion::getVersion('');
        }

        $ver = $new_version[0]['version'] ? $new_version[0]['version'] : self::DOWNLOAD_ANDROID_VER;
        if ($this->isWX) {
            $contentPath = PATH_BASE . '/../html/wx_download/wx_download.html';
            $content = file_get_contents($contentPath);
            echo $content;
            return;
        } else if ($this->isIOS) {
            $type = 1;
            //$ver = self::DOWNLOAD_IOS_VER;
            $url = self::DOWNLOAD_IOS;
        } else if ($this->isAndroid) {
            $type = 2;
            $url = $new_version[0]['url'];
        } else {
            $type = 4;
            $url = $new_version[0]['url'];

        }
        HttpUtil::goUrl($url);
        ARDownloadLog::insertLog($type, $ver);
    }


}
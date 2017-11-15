<?php

namespace backend\controllers;

use backend\components\AOutPut;
use backend\components\UAdminController;
use common\models\ar\UyeAreas;
use components\RedisUtil;
use components\UException;

/**
 * Site controller
 */
class SiteController extends UAdminController
{
    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
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
            AOutPut::info(SUCCESS, SUCCESS_CONTENT, $list);
        } catch (UException $exception) {
            AOutPut::err($exception->getCode(), $exception->getMessage());
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
            AOutPut::info(SUCCESS, SUCCESS_CONTENT, $list);
        } catch (UException $exception) {
            AOutPut::err($exception->getCode(), $exception->getMessage());
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
            AOutPut::info(SUCCESS, SUCCESS_CONTENT, $list);
        } catch (UException $exception) {
            AOutPut::err($exception->getCode(), $exception->getMessage());
        }
    }
}

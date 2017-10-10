<?php
/**
 * Created by PhpStorm.
 * User: wangyi
 * Date: 2017/10/9
 * Time: 下午7:05
 */

namespace app\modules\app\actions;


use app\modules\app\components\AppAction;
use common\models\ar\UyeCategory;
use common\models\ar\UyeConfig;
use common\models\ar\UyeSearchLog;
use components\Output;
use components\RedisUtil;
use components\UException;
use frontend\models\DataBus;

class SearchAction extends AppAction
{
    public function run()
    {
        try {
            //拉去搜索页面缓存数据
            $cacheConfig = $this->getCacheConfig();

            if (DataBus::get('uid')) {
                $searchHistory = UyeSearchLog::find()->select('*')->where('uid=:uid', [':uid' => DataBus::get('uid')])->limit(5)->offset(0)->orderBy('id desc');
            } else {
                $searchHistory = [];
            }

            //获取周边的学校
            $templateData = [
                'history' => $searchHistory,
            ];

            $templateData = \yii\helpers\ArrayHelper::merge($templateData, $cacheConfig);
            Output::info(SUCCESS, SUCCESS_CONTENT, $templateData, $this->token());
        } catch (\Exception $exception) {
            Output::err($exception->getCode(), $exception->getMessage(), array(), DataBus::get('uid'), $this->token());
        }
    }

    private function getCacheConfig()
    {
        try {
            $redis = RedisUtil::getInstance();
            $redisKey = 'UYE-SEARCH-VIEW-CONFIG';

            $data = $redis->get($redisKey);
            if ($data) {
                return json_decode($data, true);
            }

            //热门搜索词
            $config = UyeConfig::findOne(['name' => 'hot_search']);
            if (!empty($config['value'])) {
                $hotSearch = json_decode($config['value'], true);
            } else {
                $hotSearch = [];
            }

            $data = [
                'hot_search' => $hotSearch
            ];
            $redis->set($redisKey, json_encode($data));
            return $data;
        } catch (UException $exception) {
            throw new UException($exception->getMessage(), $exception->getCode());
        }
    }
}
<?php
/**
 * Created by PhpStorm.
 * User: wangyi
 * Date: 2017/9/18
 * Time: 下午3:53
 */

namespace components;


class RedisUtil extends \Redis
{
    const DB_DEFAULT = '0';
    const DB_PHONE_TOKEN = '2';

    public static function getInstance($db = self::DB_DEFAULT)
    {
        static $instance = null;
        if (!class_exists('Redis')) {
            return false;
        }
        if (!is_object($instance)) {
            $instance = new RedisUtil();
            $redisConfig = \Yii::$app->params['redis'];
            if (empty($redisConfig)) {
                return false;
            }
            try {
                if ($instance->connect($redisConfig['host'], $redisConfig['port'], $redisConfig['timeout']) == false) {
                    return false;
                }
                if (!empty($redisConfig['password'])) {
                    if ($instance->auth($redisConfig['password']) == false) {
                        return false;
                    }
                }
                $instance->select($db);
            } catch (\Exception $exception) {
                return false;
            }
        }
        return $instance;
    }
}
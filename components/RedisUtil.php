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
            $redisConfig = '';
            try {
                if ($instance->connect('127.0.0.1', '6379', 0) == false) {
                    return false;
                }
                if ($instance->auth('kz2016') == false) {
                    return false;
                }

                $instance->select($db);
            } catch (\Exception $exception) {
                return false;
            }
        }

        return $instance;
    }
}
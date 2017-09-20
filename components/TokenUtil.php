<?php
/**
 * Created by PhpStorm.
 * User: wangyi
 * Date: 2017/9/20
 * Time: 下午4:30
 */

namespace components;


class TokenUtil
{
    public static function checkToken($key, $uid = 0, $token, $isMobile = false)
    {
        $redis = RedisUtil::getInstance(RedisUtil::DB_PHONE_TOKEN);
        $redisKey = self::getRedisKey($isMobile) . md5($key);
        $exists = $redis->exists($redisKey);
        if ($exists) {
            $data = $redis->get($redisKey);
            if ($data === $token) {
                return self::refreshToken($key, $uid);
            } else {
                return false;
            }
        } else {
            return self::createToken($key, $uid);
        }
    }

    public static function createToken($key, $uid = 0, $isMobile = false)
    {
        $token = self::encryptionToken($key, $uid);
        $redis = RedisUtil::getInstance(RedisUtil::DB_PHONE_TOKEN);
        $redisKey = self::getRedisKey($isMobile) . md5($key);
        $redis->set($redisKey, $token, 24 * 60);
        return $token;
    }

    public static function refreshToken($key, $uid = 0, $isMobile = false)
    {
        $token = self::encryptionToken($key, $uid);
        $redis = RedisUtil::getInstance(RedisUtil::DB_PHONE_TOKEN);
        $redisKey = self::getRedisKey($isMobile) . md5($key);
        $redis->set($redisKey, $token, 24 * 60);
        return $token;
    }

    private static function encryptionToken($key, $uid = 0)
    {
        $tmpArr = array(
            'key' => $key,
            'uid' => $uid,
            'timestamp' => time(),
            'rand' => rand(10000, 99999)
        );
        ksort($tmpArr);
        return sha1(json_encode($tmpArr), false);
    }

    private static function getRedisKey($isMobile)
    {
        if ($isMobile) {
            return 'UYE_MOBILE_TOKEN_';
        } else {
            return 'UYE_PC_TOKEN_';
        }
    }
}
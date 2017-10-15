<?php
/**
 * Created by PhpStorm.
 * User: wangyi
 * Date: 2017/9/18
 * Time: 下午3:49
 */

namespace components;


use common\models\ar\UyeSmsRecore;

class SmsUtil
{
    const CONTENT_PREFIX = '【U业】';

    /**
     * 创建验证码
     * @param int $length
     * @return string
     */
    public static function createCode($length = 4)
    {
        $ret = '';
        for ($i = 0; $i < $length; $i++) {
            $ret .= rand(0, 9);
        }
        return $ret;
    }

    /**
     * 检查验证码是否正确
     * @param $phone 手机号
     * @param $ip   ip地址
     * @param $code 短信验证码
     * @return bool
     */
    public static function checkVerifyCode($phone, $ip, $code)
    {
        $redis = RedisUtil::getInstance();
        $redisKey = 'UYE-VERIFY-CODE-' . md5($phone . '|' . $ip);
        $data = $redis->get($redisKey);
        if ($data) {
            $params = json_decode($data, true);
            if ($params['code'] == $code) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    /**
     * 发送短信验证码
     * @param $phone
     * @param $ip
     * @param int $uid
     * @return bool
     * @throws UException
     */
    public static function sendVerifyCode($phone, $ip, $uid = 0)
    {
        $redis = RedisUtil::getInstance();
        $limitKey = 'UYE-VERIFY-CODE-LIMIT-' . md5($phone . '|' . $ip);
        $check = $redis->exists($limitKey);
        if ($check) {
            throw new UException(ERROR_PHONE_CODE_FREQUENTLY_CONTENT, ERROR_PHONE_CODE_FREQUENTLY);
        }

        $redisKey = 'UYE-VERIFY-CODE-' . md5($phone . '|' . $ip);
        $data = $redis->get($redisKey);
        if ($data) {
            $params = json_decode($data, true);
            if ($params['num'] >= 5) {
                $redis->set($limitKey, 1, 30 * 60);
                throw new UException(ERROR_PHONE_CODE_FREQUENTLY_CONTENT, ERROR_PHONE_CODE_FREQUENTLY);
            } else {
                $params['num']++;
                $redis->set($redisKey, json_encode($params), 5 * 60);
            }
        } else {
            $code = self::createCode();
            $params = array(
                'code' => $code,
                'num' => 0,
            );
            $redis->set($redisKey, json_encode($params), 5 * 60);
        }

        $content = self::CONTENT_PREFIX . '短信验证码：[' . $params['code'] . ']，请勿泄露。';
        self::send($phone, $content, $uid);
        return true;
    }

    /**
     * 发送短信，并记录短信内容
     * @param $phone
     * @param $content
     * @param int $uid
     * @throws UException
     */
    public static function send($phone, $content, $uid = 0)
    {
        try {
            $inster = array(
                'uid' => $uid,
                'type' => 1,
                'phone' => $phone,
                'content' => $content,
                'created_time' => time(),
                'updated_time' => time(),
            );
            UyeSmsRecore::_addInfo($inster);

            self::sendHaobo($phone, $content);
        } catch (\Exception $exception) {
            throw new UException($exception->getCode(), $exception->getMessage());
        }
    }

    /**
     * 发送短信 昊博  http://www.hb-media.cn/
     * @param type $mobile
     * @param type $content
     * @return bool|string
     */
    private static function sendHaobo($mobile, $content)
    {
        // 帐号
        $config = \Yii::$app->params['haobo'];
        if (empty($config) || empty($config['user']) || empty($config['password']) || empty($config['url'])) {
            throw new UException(ERROR_SECRET_CONFIG_NO_EXISTS_CONTENT, ERROR_SECRET_CONFIG_NO_EXISTS);
        }
        extract($config);
        $post_data = array(
            'un' => $user,
            'pw' => $password,
            'da' => $mobile,
            'sm' => bin2hex(iconv("UTf-8", "GB2312", $content)),
            'dc' => 15,
            'rd' => 0,
        );
        $tmpArr = array();
        foreach ($post_data as $k => $v) {
            $tmpArr[] = "{$k}={$v}";
        }

        try {
            $res = HttpUtil::doPost($url, array('request' => implode('&', $tmpArr)), false);
            if (strpos($res, 'id=') !== false) {
                $ret = substr($res, 3, strlen($res) - 3);
            } else {
                throw new UException('发送失败');
            }
        } catch (\Exception $e) {
            return false;
        }
        return $ret;
    }


    private static function sendYunpian($mobile, $content)
    {
        $url = '';
        $apiKey = '';
        $content = rawurlencode("{$content}");
        $postData = "apikey={$apiKey}&mobile={$mobile}&text={$content}";
        try {
            $res = HttpUtil::doPost($url, array('request' => $postData,), false);
            $result = json_decode($res, true);
            if (!$result || !isset($result['code']) || $result['code'] != '0') {
                throw new UException('发送失败');
            } else {
                $ret = 0;
            }
        } catch (\Exception $e) {
            $ret = false;
        }
        //解析结果
        return $ret;
    }
}
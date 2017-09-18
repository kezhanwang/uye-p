<?php
/**
 * Created by PhpStorm.
 * User: wangyi
 * Date: 2017/9/18
 * Time: 上午11:40
 */

namespace console\controllers;


use components\CookieUtil;
use yii\console\Controller;

class TestController extends Controller
{
    const db_hash = 'sec&*#%lTc';

    public function actionIndex()
    {
        $uid = 1000000;
        $password = md5($uid);

        $strCode = $uid . "\t" . $password;
        var_dump($strCode);
        $strCodeEncode = self::strCode($strCode);
        var_dump($strCodeEncode);
        $strCodeDeCode = self::strCode($strCodeEncode, 'DECODE');
        var_dump($strCodeDeCode);
    }

    public static function strCode($string, $action = 'ENCODE')
    {
        $action != 'ENCODE' && $string = base64_decode($string);
        $code = '';
        $key = substr(md5(self::db_hash), 8, 18);
        $keyLen = strlen($key);
        $strLen = strlen($string);
        for ($i = 0; $i < $strLen; $i++) {
            $k = $i % $keyLen;
            $code .= $string[$i] ^ $key[$k];
        }
        return ($action != 'DECODE' ? base64_encode($code) : $code);
    }
}
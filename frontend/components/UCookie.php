<?php
/**
 * Created by PhpStorm.
 * User: wangyi
 * Date: 2017/9/15
 * Time: 下午12:46
 */

namespace frontend\components;


class UCookie
{
    const DB_CKPATH = '/';
    const DB_CKDOMAIN = '.kezhanwang.cn';
    const DB_SITEID = '0ae32fa90927d3d868fde52085c8aa24';
    const DB_BBSNAME = '课栈网';
    const DB_BBSURL = 'http://www.kezhanwang.cn';
    const DB_REGISTERFILE = 'page/confirm';

    public static function illegalChar()
    {
        return array(
            "\\", '&', ' ', "'", '"', '/', '*', ',', '<', '>', "\r", "\t", "\n", '#', '%', '?', '　', '..', '$', '{', '}', '(', ')', '+', '=', '-', '[', ']', '|', '!', '@', '^', '.', '~', '`'
        );
    }

    public static function Cookie()
    {
        $timestamp = time();
        $server = $_SERVER;
        $cookieDomain = '.' . DOMAIN_BASE;
        static $sIsSecure = null;
        if ($sIsSecure === null) {

        }
    }
}
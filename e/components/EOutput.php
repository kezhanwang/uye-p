<?php
/**
 * Created by PhpStorm.
 * User: wangyi
 * Date: 2017/10/24
 * Time: 下午3:34
 */

namespace e\components;


class EOutput
{
    public static function err($code, $msg, $data = array())
    {
        if (empty($data)) {
            $data = new \stdClass();
        }

        $tmpArr = [
            'code' => $code,
            'msg' => $msg,
            'data' => $data,
            'timestamp' => time()
        ];
        $tmpJson = json_encode($tmpArr);
        echo $tmpJson;
        exit();
    }

    public static function info($code, $msg, $data = array())
    {
        if (empty($data)) {
            $data = new \stdClass();
        }

        $tmpArr = [
            'code' => $code,
            'msg' => $msg,
            'data' => $data,
            'timestamp' => time()
        ];
        $tmpJson = json_encode($tmpArr);
        echo $tmpJson;
    }
}
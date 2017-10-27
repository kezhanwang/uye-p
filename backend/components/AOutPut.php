<?php
/**
 * Created by PhpStorm.
 * User: wangyi
 * Date: 2017/10/27
 * Time: 上午11:43
 */

namespace backend\components;


class AOutPut
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
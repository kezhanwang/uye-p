<?php
/**
 * Created by PhpStorm.
 * User: wangyi
 * Date: 2017/10/12
 * Time: 下午4:47
 */

namespace common\models\udcredit;


use components\UException;

class UdcreditNotify extends UdcreditBase
{
    const SUCCESS = 1;
    const SUCCESS_MSG = "接收成功";
    const FAIL = 0;
    const FAIL_MSG = "接收失败";

    /**
     * @param $params
     * @return array
     * @throws \components\UException
     */
    public static function Init($params)
    {
        $obj = new self();
        $obj->setValues($params);
        $obj->CheckSign();
        // 更新数据
        return $obj->GetValues();
    }

    public function CheckSign()
    {
        if (!$this->IsSignSet()) {
            throw new UException("签名错误！");
        }

        $sign = $this->MakeSign();
        if ($this->GetSign() == $sign) {
            return true;
        }
        throw new UException("签名错误！sing=" . $sign);
    }

    /**
     *
     * 设置参数
     * @param string $key
     * @param string $value
     */
    public function SetData($key, $value)
    {
        $this->values[$key] = $value;
    }

    /**
     * 返回通知结果
     * @param bool $isSuccess
     */
    public static function ReplyNotify($isSuccess = false)
    {
        if ($isSuccess) {
            echo json_encode(array('code' => UdcreditNotify::SUCCESS, 'message' => UdcreditNotify::SUCCESS_MSG));
        } else {
            echo json_encode(array('code' => UdcreditNotify::FAIL, 'message' => UdcreditNotify::FAIL_MSG));
        }
        return;
    }
}
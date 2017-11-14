<?php
/**
 * Created by PhpStorm.
 * User: wangyi
 * Date: 2017/10/12
 * Time: 下午4:48
 */

namespace common\models\udcredit;


use components\UException;

class UdcreditBase
{
    protected $values = array();

    /**
     * 设置签名，详见签名生成算法
     **/
    public function SetSign()
    {
        $sign = $this->MakeSign();
        $this->values['sign'] = $sign;
        return $sign;
    }

    /**
     * 获取签名，详见签名生成算法的值
     * @return 值
     **/
    public function GetSign()
    {
        return strtolower($this->values['sign']);
    }

    /**
     * 判断签名，详见签名生成算法是否存在
     * @return true 或 false
     **/
    public function IsSignSet()
    {
        $isSign = array_key_exists('sign', $this->values);
        if ($isSign) {
            return true;
        }
        return false;
    }

    /**
     * @param $params
     * @return array
     * @throws UException
     */
    public function setValues($params)
    {
        if (!$params) {
            throw new UException(ERROR_SYS_PARAMS_CONTENT, ERROR_SYS_PARAMS);
        }
        $this->values = $params;
        return $this->values;
    }

    /**
     * 格式化参数格式化成url参数
     */
    public function ToSignParams()
    {
        $buff = 'partner_order_id=' . $this->values['partner_order_id'] . '|sign_time=' . $this->values['sign_time'];
        return $buff;
    }

    /**
     *  生成签名
     * @return 签名，本函数不覆盖sign成员变量，如要设置签名需要调用SetSign方法赋值
     * @throws UException
     */
    public function MakeSign()
    {
        $string = $this->ToSignParams();
        //签名步骤二：在string后加入KEY
        $config = \Yii::$app->params['udcredit'];
        if (empty($config)) {
            throw new UException(ERROR_SECRET_CONFIG_NO_EXISTS_CONTENT, ERROR_SECRET_CONFIG_NO_EXISTS);
        }
        $string = 'pub_key=' . $config['pub_key'] . '|' . $string . '|security_key=' . $config['security_key'];
        //签名步骤三：MD5加密
        $result = md5($string);
        return $result;
    }

    /**
     * 获取设置的值
     */
    public function GetValues()
    {
        return $this->values;
    }
}
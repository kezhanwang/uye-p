<?php
/**
 * Created by PhpStorm.
 * User: wangyi
 * Date: 2017/9/18
 * Time: 上午10:38
 */

namespace components;


use Throwable;

class UException extends \Exception
{
    public function __construct($message = "", $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }

    public static function dealAR($ar)
    {
        $msg = 'error:' . var_export($ar->getErrors(), true) . "\nattrs:" . var_export($ar->getAttributes(), true);
        \Yii::error($msg, 'db');
        throw new UException($msg, ERROR_DB);
    }
}
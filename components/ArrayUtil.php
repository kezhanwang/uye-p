<?php
/**
 * Created by PhpStorm.
 * User: wangyi
 * Date: 2017/9/18
 * Time: 上午10:57
 */

namespace components;


class ArrayUtil
{
    public static function trimArray($arr)
    {
        $ret = array();
        foreach ($arr as $key => $value) {
            if (is_array($value)) {
                $ret[$key] = ArrayUtil::trimArray($value);
            } else if (is_string($value)) {
                $ret[$key] = trim($value);
            } else {
                $ret[$key] = $value;
            }
        }

        return $ret;
    }
}
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

    /**
     * @param $arr
     * @return array
     */
    public static function escapeEmpty($arr)
    {
        $ret = array();
        foreach ($arr as $key => $val) {
            if ($val !== null && $val !== '') {
                $ret[$key] = $val;
            }
        }
        return $ret;
    }

    /**
     * 按长度区间进行截取
     * @param type $arr
     * @param type $max
     * @param int $min
     * @param string $encoding
     * @return array
     */
    public static function escapeByStrlen($arr, $max, $min = 0, $encoding = 'UTF-8')
    {
        $ret = array();
        foreach ($arr as $key => $val) {
            $len = mb_strlen($val, $encoding);
            if ($len >= $min && $len <= $max) {
                $ret[$key] = $val;
            }
        }
        return $ret;
    }

    /**
     * 按照字符串长度排序
     * @param type $arr
     * @return array
     */
    public static function sortByStrlen($arr, $order = SORT_ASC, $encoding = 'UTF-8')
    {
        $lenArr = array();
        foreach ($arr as $key => $val) {
            $lenArr[$key] = mb_strlen($val, $encoding);
        }
        if ($order == SORT_DESC) {
            arsort($lenArr);
        } else {
            asort($lenArr);
        }
        $ret = array();
        foreach ($lenArr as $key => $val) {
            $ret[] = $arr[$key];
        }
        return $ret;
    }
}
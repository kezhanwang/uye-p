<?php
/**
 * Created by PhpStorm.
 * User: wangyi
 * Date: 2017/9/18
 * Time: 下午12:06
 */

namespace components;


class PicUtil
{
    /**
     * 获得后缀名
     * @param $str
     * @return bool|string
     */
    public static function getSuffix($str)
    {
        $pos = strrpos($str, '.');
        if ($pos !== false) {
            return substr($str, $pos + 1);
        } else {
            return '';
        }
    }

    public static $fontsizeArr = array(
        6.5 => 8,
        7.5 => 10,
        9 => 12,
        10.5 => 14,
        12 => 16,
        14 => 18,
        15 => 20,
        16 => 21,
        18 => 24,
        22 => 29,
        24 => 32,
        26 => 34,
        36 => 48,
        42 => 56,
    );

    /**
     * 根据字号计算对应的像素
     * @param $size
     * @return mixed
     */
    public static function fontToPixel($size)
    {
        $arr = self::$fontsizeArr;
        $right = 6.5;
        $diff = 100;
        foreach ($arr as $key => $val) {
            if ($size - $key < 0) {
                break;
            }
            if ($size - $key < $diff) {
                $right = $key;
                $diff = abs($size - $key);
            }
        }
        return $arr[$right];
    }

    /**
     * 像素转成字体
     * @param $pixel
     * @return mixed
     */
    public static function pixelToFont($pixel)
    {
        $arr = array_flip(self::$fontsizeArr);
        $right = 8;
        $diff = 100;
        foreach ($arr as $key => $val) {
            if ($pixel - $key < 0) {
                break;
            }
            if ($pixel - $key < $diff) {
                $right = $key;
                $diff = abs($pixel - $key);
            }
        }
        return $arr[$right];
    }
}
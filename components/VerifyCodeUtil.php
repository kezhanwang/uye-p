<?php
/**
 * Created by PhpStorm.
 * User: wangyi
 * Date: 2017/9/18
 * Time: 下午12:04
 */

namespace components;


class VerifyCodeUtil
{
    const KEY_NAME = 'uye_vp';

    public static function createCode($num = 4)
    {
        $str = "23456789abcdefghijkmnpqrstuvwxyzABCDEFGHIJKLMNPQRSTUVW";
        $code = '';
        for ($i = 0; $i < $num; $i++) {
            $code .= $str[mt_rand(0, strlen($str) - 1)];
        }
        return $code;
    }

    public static function getCode($num = 4, $size = 18, $width = 0, $height = 0, $isMobile = false)
    {
        if (empty($num)) {
            $num = 4;
        }
        if (empty($size) || $size <= 10) {
            $size = 18;
        }
        if (!is_numeric($width) || $width <= 50) {
            $width = 0;
        }
        if (!is_numeric($height) || $height <= 10) {
            $height = 0;
        }
        !$width && $width = $num * $size * 4 / 5 + 5;
        !$height && $height = $size + 10;
        $code = self::createCode($num);
        // 画图像
        $im = imagecreatetruecolor($width, $height);
        // 定义要用到的颜色
        $back_color = imagecolorallocate($im, 235, 236, 237);
        $boer_color = imagecolorallocate($im, 118, 151, 199);
        $text_color = imagecolorallocate($im, mt_rand(0, 200), mt_rand(0, 120), mt_rand(0, 120));
        // 画背景
        imagefilledrectangle($im, 0, 0, $width, $height, $back_color);
        // 画边框
        imagerectangle($im, 0, 0, $width - 1, $height - 1, $boer_color);
        // 画干扰线
        for ($i = 0; $i < 5; $i++) {
            $font_color = imagecolorallocate($im, mt_rand(0, 255), mt_rand(0, 255), mt_rand(0, 255));
            imagearc($im, mt_rand(-$width, $width), mt_rand(-$height, $height), mt_rand(30, $width * 2), mt_rand(20, $height * 2), mt_rand(0, 360), mt_rand(0, 360), $font_color);
        }
        // 画干扰点
        for ($i = 0; $i < 50; $i++) {
            $font_color = imagecolorallocate($im, mt_rand(0, 255), mt_rand(0, 255), mt_rand(0, 255));
            imagesetpixel($im, mt_rand(0, $width), mt_rand(0, $height), $font_color);
        }
        // 画验证码
        $size = PicUtil::pixelToFont($height - 10);
        $sizeHeight = PicUtil::fontToPixel($size);
        $y = abs($height - $sizeHeight) / 2 + $sizeHeight - 5;
        $x = abs($width - $sizeHeight) / 2 - 5;
        @imagefttext($im, $size, 0, $x, $y, $text_color, dirname(__FILE__) . '/id-isi-light.ttc', $code);
        $encode = self::encodeCode($code);
        CookieUtil::setCookie(self::KEY_NAME, $encode);
        if ($isMobile) {
            $imageFile = PATH_AUDIT . '/vccodetmp.png';
            imagepng($im, $imageFile);
            imagedestroy($im);
            $imageFileHandle = fopen($imageFile, 'rb');
            $imageFileData = fread($imageFileHandle, filesize($imageFile));
            fclose($imageFileHandle);
            unlink($imageFile);
            return $imageFileData;
        } else {
            header("Cache-Control: max-age=1, s-maxage=1, no-cache, must-revalidate");
            header("Content-type: image/png;charset=utf-8");
            imagepng($im);
            imagedestroy($im);
        }
    }

    /**
     * 加密验证码的算法.
     * $code字符串分别加上,计算ord之和,模10,选中一个因子,然后得到的数字再拼成字符串,做md5
     * @param type $code
     */
    public static function encodeCode($code)
    {
        $code = strtolower($code);
        $ordArr = array();
        $ordSum = 0;
        $strArr = str_split($code, 1);
        foreach ($strArr as $key => $val) {
            $ordArr[$key] = ord($val);
            $ordSum += $ordArr[$key];
        }
        $params = array(0 => 8, 1 => 4, 2 => 3, 3 => 8, 4 => 4, 5 => 0, 6 => 3, 7 => 1, 8 => 7, 9 => 3,);
        $seed = $params[$ordSum % 10];
        $ret = '';
        foreach ($ordArr as $key => $val) {
            $ret .= ($val + $seed) . '';
        }
        return md5($ret);
    }

    /**
     * 比较code和密文是否正确
     * @param null $code
     * @param null $encode
     * @return bool
     * @throws UException
     */
    public static function checkCode($code = null, $encode = null)
    {
        if ($code === null) {
            throw new UException();
        }
        //获取cookie中的加密串
        if ($encode === null) {
            $key = self::KEY_NAME;
            $encode = $_COOKIE[$key];
        }
        //检查是否相同
        $calcEncode = self::encodeCode($code);
        $ret = false;
        if ($calcEncode === $encode) {
            $ret = true;
        }
        return $ret;
    }
}
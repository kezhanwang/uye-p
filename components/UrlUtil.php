<?php
/**
 * Created by PhpStorm.
 * User: wangyi
 * Date: 2017/10/16
 * Time: 下午6:22
 */

namespace components;


class UrlUtil
{
    /**
     * 根据URL取得linux下静态资源文件路径
     */
    public static function urlForLinuxPath($url = null)
    {
        if ($url === null)
            return false;

        $search = '.com/';
        $pos = strpos($url, $search);
        if ($pos !== false) {
            $path = substr($url, $pos + strlen($search) - 1);
        } else {
            $path = $url;
        }
        return $path;
    }
}
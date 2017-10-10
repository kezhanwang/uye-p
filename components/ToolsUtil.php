<?php
/**
 * Created by PhpStorm.
 * User: wangyi
 * Date: 2017/10/10
 * Time: 下午5:51
 */

namespace components;


class ToolsUtil
{
    /**
     * 根据URL取得linux下静态资源文件路径
     */
    public static function urlForLinuxPath($url = null)
    {
        if ($url === null)
            return false;

        $search = '.cn/';
        $pos = strpos($url, $search);
        if ($pos !== false) {
            $path = substr($url, $pos + strlen($search) - 1);
        } else {
            $path = $url;
        }
        return $path;
    }
}
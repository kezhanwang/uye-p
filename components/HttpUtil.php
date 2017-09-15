<?php
/**
 * Created by PhpStorm.
 * User: wangyi
 * Date: 2017/9/15
 * Time: 下午3:27
 */

namespace components;


class HttpUtil
{
    public static function arrayToXml($arr, $dom = 0, $item = 0, $trimXmlTag = true)
    {
        if (!$dom) {
            $dom = new \DOMDocument("1.0");
        }

        if (is_string($item)) {
            $item = $dom->createElement($item);
        } else if (!$item) {
            $item = $dom->createElement('root');
        }
        $dom->appendChild($item);

        foreach ($arr as $key => $value) {
            $itemX = $dom->createElement(is_string($key) ? $key : 'item');
            $item->appendChild($itemX);
            if (!is_array($value)) {
                $textNode = $dom->createTextNode($value);
                $itemX->appendChild($textNode);
            } else {
                self::arrayToXml($value, $dom, $itemX);
            }
        }

        if ($trimXmlTag) {
            $result = str_replace(array('<?xml version="1.0"?>',), array('',), $dom->saveXML());
        } else {
            $result = $dom->saveXML();
        }
        return $result;
    }

    /**
     * 将xml字符串转成数组
     * @param $xmlStr
     * @return array
     */
    public static function xmlToArray($xmlStr)
    {
        $sxi = new SimpleXmlIterator($xmlStr, LIBXML_NOCDATA);
        return self::sxiToArray($sxi);
    }

    private static function sxiToArray($sxi)
    {
        $RET = array();
        for ($sxi->rewind(); $sxi->valid(); $sxi->next()) {
            if ($sxi->hasChildren()) {
                if (!array_key_exists($sxi->key(), $RET)) {
                    $RET[$sxi->key()] = array();
                }
                $RET[$sxi->key()][] = self::sxiToArray($sxi->current());
            } else {
                $RET[$sxi->key()] = (string)$sxi->current();
            }
        }
        return $RET;
    }

    /**
     * 跳转地址
     */
    public static function goUrl($url)
    {
        header("Location: {$url}");
    }

    /**
     * 跳转地址
     */
    public static function go301($url)
    {
        header("http/1.1 301 moved permanently");
        header("Location: {$url}");
    }

    /**
     * 跳转到404页
     */
    public static function go404()
    {
        $url = '/html/404/error.html';
        self::go301($url);
    }

    public static function goLogin()
    {
        $url = '';
        if (strpos($url, '?') === false) {
            $url .= '?';
        } else {
            $url .= '&';
        }
        $url .= 'jumpurl=' . urlencode(("http://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']));
        self::goUrl($url);
    }
}
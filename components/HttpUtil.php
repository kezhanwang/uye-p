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
        $url = DOMAIN_WWW . '/login/login';
        if (strpos($url, '?') === false) {
            $url .= '?';
        } else {
            $url .= '&';
        }
        $url .= 'jumpurl=' . urlencode(("http://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']));
        self::goUrl($url);
    }


    public static function doPost($url, $optArr = array(), $needThrow = true)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HEADER, false);
        if (isset($optArr['ua'])) {
            curl_setopt($ch, CURLOPT_USERAGENT, $optArr['ua']);
        } else {
            curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 6.1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/31.0.1650.57 Safari/537.36');
        }
        if (isset($optArr['referer'])) {
            curl_setopt($ch, CURLOPT_REFERER, $optArr['referer']);
        }
        if (isset($optArr['header'])) {
            curl_setopt($ch, CURLOPT_HTTPHEADER, $optArr['header']);
        }
        $timeOut = 3;
        if (isset($optArr['timeout'])) {
            $timeOut = intval($optArr['timeout']);
        }

        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeOut); //conn timeout
        curl_setopt($ch, CURLOPT_TIMEOUT, $timeOut); //execute timeout
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        if (isset($optArr['cookie'])) {
            curl_setopt($ch, CURLOPT_COOKIE, $optArr['cookie']);
        }
        if (isset($optArr['request'])) {
            curl_setopt($ch, CURLOPT_POSTFIELDS, $optArr['request']);
        }
        if (isset($optArr['proxy'])) {
            curl_setopt($ch, CURLOPT_PROXY, $optArr['proxy']);
        }

        $tryCnt = 1;
        $success = true;
        do {
            $data = curl_exec($ch);
            $errno = curl_errno($ch);
            if ($errno != 0) {
                usleep(10000);
                $success = false;
                if ($tryCnt >= 3) {
                    $error = curl_error($ch);
                    $message = "curl erron:{$errno},error:{$error},url:{$url}";
                    curl_close($ch);
                    throw new \Exception($message, $errno);
                }
            } else {
                $success = true;
            }
        } while (!$success && $tryCnt++ < 3);

        $errno = curl_errno($ch);
        if ($errno != 0) {
            $error = curl_error($ch);
            $message = "curl erron:{$errno},error:{$error},url:{$url}";
            curl_close($ch);
            throw new \Exception($message, $errno);
        }

        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        if ($needThrow && $httpCode != 200) {
            $message = "http code:{$httpCode},url:{$url}";
            curl_close($ch);
            throw new \Exception($message, $httpCode);
        }
        curl_close($ch);
        return $data;
    }

    /**
     * @param $url
     * @param array $optionArray
     * @return mixed
     * @throws \Exception
     */
    public static function doGet($url, $optionArray = array())
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HEADER, false); //CURLOPT_HEADER
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 6.1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/31.0.1650.57 Safari/537.36');
        if (isset($optionArray['referer'])) {
            curl_setopt($ch, CURLOPT_REFERER, $optionArray['referer']);
        }
        $timeOut = 3;
        if (isset($optionArray['timeout'])) {
            $timeOut = intval($optionArray['timeout']);
        }

        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeOut); //conn timeout
        curl_setopt($ch, CURLOPT_TIMEOUT, $timeOut); //execute timeout
        if (isset($optionArray['proxy'])) {
            curl_setopt($ch, CURLOPT_PROXY, $optionArray['proxy']);
        }
        if (isset($optionArray['header'])) {
            curl_setopt($ch, CURLOPT_HTTPHEADER, $optionArray['header']);
        }
        if (isset($optionArray['cookie'])) {
            curl_setopt($ch, CURLOPT_COOKIE, $optionArray['cookie']);
        }
        if (isset($optionArray['raw'])) {
            curl_setopt($ch, CURLOPT_HEADER, $optionArray['raw']);
        }

        if (isset($optionArray['referer'])) {
            curl_setopt($ch, CURLOPT_REFERER, $optionArray['referer']);
        }

        $tryCnt = 1;
        $success = true;
        do {
            $data = curl_exec($ch);
            $errno = curl_errno($ch);
            if ($errno != 0) {
                usleep(10000);
                $success = false;
                if ($tryCnt >= 1) {
                    $error = curl_error($ch);
                    $message = "curl erron:{$errno},error:{$error},url:{$url}";
                    curl_close($ch);
                    throw new \Exception($message, $errno);
                }
            } else {
                $success = true;
            }
        } while (!$success && $tryCnt++ < 1);

        $errno = curl_errno($ch);
        if ($errno != 0) {
            $error = curl_error($ch);
            $message = "curl erron:{$errno},error:{$error},url:{$url}";
            curl_close($ch);
            throw new \Exception($message, $errno);
        }

        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        if ($httpCode != 200) {
            $message = "http code:{$httpCode},url:{$url}";
            curl_close($ch);
            throw new \Exception($message, $httpCode);
        }
        curl_close($ch);
        return $data;
    }

    public static function doGetWithHeader($url, $optionArray = array())
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HEADER, true); //CURLOPT_HEADER
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);


        $timeOut = 3;
        if (isset($optionArray['timeout'])) {
            $timeOut = intval($optionArray['timeout']);
        }

        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeOut); //conn timeout
        curl_setopt($ch, CURLOPT_TIMEOUT, $timeOut); //execute timeout
        if (isset($optionArray['proxy'])) {
            curl_setopt($ch, CURLOPT_PROXY, $optionArray['proxy']);
        }
        if (isset($optionArray['header'])) {
            curl_setopt($ch, CURLOPT_HTTPHEADER, $optionArray['header']);
        }
        if ($optionArray['cookie']) {
            curl_setopt($ch, CURLOPT_COOKIE, $optionArray['cookie']);
        }
        if ($optionArray['raw']) {
            curl_setopt($ch, CURLOPT_HEADER, $optionArray['raw']);
        }

        $tryCnt = 1;
        $success = true;
        do {
            $data = curl_exec($ch);
            $errno = curl_errno($ch);
            if ($errno != 0) {
                usleep(10000);
                $success = false;
                if ($tryCnt >= 1) {
                    $error = curl_error($ch);
                    $message = "curl erron:{$errno},error:{$error},url:{$url}";
                    curl_close($ch);
                    throw new \Exception($message, $errno);
                }
            } else {
                $success = true;
            }
        } while (!$success && $tryCnt++ < 1);

        $errno = curl_errno($ch);
        if ($errno != 0) {
            $error = curl_error($ch);
            $message = "curl erron:{$errno},error:{$error},url:{$url}";
            curl_close($ch);
            throw new \Exception($message, $errno);
        }

        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $headerSize = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
        if ($httpCode != 200) {
            $message = "http code:{$httpCode},url:{$url}";
            curl_close($ch);
            throw new \Exception($message, $httpCode);
        }
        curl_close($ch);
        $result['header'] = substr($data, 0, $headerSize);
        $result['content'] = substr($data, $headerSize);
        return $result;
    }

    public static function getContent($url, $optionArray = array())
    {
        return self::doGet($url, $optionArray);
    }

    public static function parseRawData($data)
    {
        $cookie = '';
        $start = 0;
        $index = strpos($data, "\r\n\r\n");
        $header = substr($data, 0, $index);
        $strData = substr($data, $index + 4);

        do {
            $index = strpos($header, "\r\n", $start);
            if ($index !== false) {
                $line = substr($header, $start, $index - $start);
                $start = $index + 2;
            } else {
                $line = substr($header, $start);
            }
            if (0 === strncasecmp($line, "Set-Cookie: ", strlen("Set-Cookie: "))) {
                $pos = strpos($line, ";");
                $oneCookie = substr($line, strlen("Set-Cookie: "), $pos + 1 - strlen("Set-Cookie: "));
                if (strpos($oneCookie, '=EXPIRED;') === false) {
                    $cookie .= $oneCookie;
                }
            }
        } while ($index && !empty($line));
        return array('data' => $strData, 'cookie' => $cookie);
    }

}
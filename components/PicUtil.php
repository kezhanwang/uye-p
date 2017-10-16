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

    /**
     * 允许上传的文件类型
     * @var type
     */
    public static $picType = array(
        'image/jpeg' => 'jpg',
        'image/pjpeg' => 'jpg',
        'image/png' => 'png',
        'image/x-png' => 'png',
        'application/octet-stream' => 'jpg',
    );

    const RAND_BEGIN = 1;
    const RAND_END = 9999;
    const THUMB_WIDTH = 320;
    const MIDDLE_WIDTH = 800;
    const MIDDLE_SIZE = 1048576;

    const SECRET_ALL = 0;       //所有用户都可见
    const SECRET_ADMIN = 1;     //管理员可见
    const SECRET_IMAGES = 2;    //素材类的图片

    const ICON_MIDDLE = 120;
    const ICON_SMALL = 48;

    public static function uploadPic($secret = 0, $to_thumb_keys = array(), &$fileInfo = array(), $is_small_keys = array())
    {
        $ret = array();
        if (empty($_FILES)) {
            return $ret;
        }
        $files = array();
        foreach ($_FILES as $key => $file) {
            if (is_array($file['name'])) {
                foreach ($file as $k => $v) {
                    $count = count($v);
                    for ($i = 0; $i < $count; $i++) {
                        $files[$key . '_' . $i][$k] = $v[$i];
                    }
                }
            } else {
                $files[$key] = $file;
            }
        }
        foreach ($files as $key => $file) {
            foreach ($file as $k => $v) {
                if (count($k) > 1) {
                    if (is_array($file[$k]) && $v) {
                        $file[$k] = array_shift($v);
                    }
                }
            }

            switch ($file['error']) {
                case 1:
                    $msg = '文件大小超出了服务器的空间大小';
                    break;
                case 2:
                    $msg = '要上传的文件大小超出浏览器限制';
                    break;
                case 3:
                    $msg = '文件仅部分被上传';
                    break;
                case 4:
                    $msg = '没有找到要上传的文件';
                    break;
                case 5:
                    $msg = '服务器临时文件夹丢失';
                    break;
                case 6:
                    $msg = '文件写入到临时文件夹出错';
                    break;
                default:
                    $msg = false;
                    break;
            }
            if ($msg) {
                throw new UException(ERROR_UPLOAD_CODE_CONTENT . ":" . $msg, ERROR_UPLOAD_CODE);
            }
            if (empty($file['tmp_name'])) {
                continue;
            }

            $imageSize = getimagesize($file['tmp_name']);
            if (!$imageSize) {
                throw new UException("文件上传失败,请选择正确的图片格式", ERROR_UPLOAD_CODE);
            }
            $fileInfo['imagesize'] = $imageSize;
            if ($file['error'] != 0) {
                throw new UException("文件 {$key} 上传失败,错误码:{$file['error']}", ERROR_UPLOAD_CODE);
            }
            if (!isset(self::$picType[$file['type']])) {
                throw new UException("不支持上传 {$file['type']} 类型的文件", ERROR_UPLOAD_CODE);
            }
            $suffix = self::$picType[$file['type']];
            //计算保存路径
            $date_dir = DIRECTORY_SEPARATOR . date("Ym") . DIRECTORY_SEPARATOR . date("d");
            if ($secret == self::SECRET_ADMIN) {
                $dir = PATH_UPLOAD_SECRET . $date_dir;
            } else {
                $dir = PATH_UPLOAD . $date_dir;
            }
            if (!file_exists($dir)) {
                mkdir($dir, 0777, true);
            }
            $fileInfo['dir'] = $dir;
            do {
                $fileName = date('His') . '_' . intval(microtime(true)) . '_' . rand(self::RAND_BEGIN, self::RAND_END) . ".{$suffix}";
                $sFileName = date('His') . '_' . intval(microtime(true)) . '_' . rand(self::RAND_BEGIN, self::RAND_END) . "_s.{$suffix}";
                $path = DIRECTORY_SEPARATOR . $fileName;
                $s_path = DIRECTORY_SEPARATOR . $sFileName;
            } while (file_exists($dir . $path));
            $fileInfo['path'] = $dir . $path;
            $fileInfo['fileName'] = $fileName;
            $fileInfo['fullName'] = $dir . $path;
            $fileInfo['original'] = $file['name'];
            $fileInfo['size'] = $file['size'];
            $fileInfo['type'] = $suffix;
            //上传图片大于1M ，自动裁剪未宽800 ，高自动的小图
            if ($file['size'] > self::MIDDLE_SIZE) {
                $tmp = self::toThumb($file['tmp_name'], $dir . $path, self::MIDDLE_WIDTH);
            } elseif (in_array($key, $is_small_keys) && $imageSize[0] > self::MIDDLE_WIDTH) {
                $tmp = self::toThumb($file['tmp_name'], $dir . $path, self::MIDDLE_WIDTH);
            } else {
                if (!($tmp = @copy($file['tmp_name'], $dir . $path))) {
                    $tmp = @move_uploaded_file($file['tmp_name'], $dir . $path);
                }
            }
            if ($tmp) {
                if (in_array($key, $to_thumb_keys)) {
                    $thumb_res = self::toThumb($dir . $path, $dir . $s_path);
                    if (!$thumb_res)
                        throw new UException("生成小图失败！", ERROR_UPLOAD_CODE);
                }
                $fileType = self::getFileType($dir . $path);
                if (!in_array($fileType, self::$picType)) {
                    @unlink($dir . $path);
                    @unlink($dir . $s_path);
                    throw new UException("不支持上传 {$fileType} 类型的文件", ERROR_UPLOAD_CODE);
                }
                if (!in_array($key, $to_thumb_keys))
                    $ret[$key] = str_replace('\\', '/', $date_dir . $path);
                else
                    $ret[$key] = array(str_replace('\\', '/', $date_dir . $path),
                        str_replace('\\', '/', $date_dir . $s_path));
            } else {
                throw new UException("文件 {$key} 上传失败", ERROR_UPLOAD_CODE);
            }
        }
        return $ret;
    }

    public static function toThumb($file, $s_path, $s_width = self::THUMB_WIDTH)
    {
        $fileInfo = getimagesize($file);
        $width = $fileInfo[0];
        $height = $fileInfo[1];
        $s_height = ceil($height / ($width / $s_width));

        switch ($fileInfo['mime']) {
            case 'image/gif':
                $imgData = @imagecreatefromgif($file);
                break;
            case 'image/jpeg':
                $imgData = @imagecreatefromjpeg($file);
                break;
            case 'image/png':
                $imgData = @imagecreatefrompng($file);
                break;
        }
        $newimg = imagecreatetruecolor($s_width, $s_height);
        $color = imagecolorallocate($newimg, 255, 255, 255);
        imagecolortransparent($newimg, $color);
        imagefill($newimg, 0, 0, $color);
        $r_1 = imagecopyresampled($newimg, $imgData, 0, 0, 0, 0, $s_width, $s_height, $width, $height);
        $r_2 = ImageJpeg($newimg, $s_path);
        imagedestroy($imgData);
        return $r_1 && $r_2 ? true : false;
    }

    /**
     * 检查文件的真实类型
     * @param $filename
     * @return string
     */
    public static function getFileType($filename)
    {
        $file = fopen($filename, "rb");
        $bin = fread($file, 2);
        fclose($file);
        $strInfo = @unpack("C2chars", $bin);
        $typeCode = intval($strInfo['chars1'] . $strInfo['chars2']);
        $fileType = '';
        switch ($typeCode) {
            case 7790:
                $fileType = 'exe';
                break;
            case 7784:
                $fileType = 'midi';
                break;
            case 8297:
                $fileType = 'rar';
                break;
            case 255216:
                $fileType = 'jpg';
                break;
            case 7173:
                $fileType = 'gif';
                break;
            case 6677:
                $fileType = 'bmp';
                break;
            case 13780:
                $fileType = 'png';
                break;
            default:
                $fileType = 'unknown';
        }
        return $fileType;
    }

    /**
     * 获取多个图片地址
     * @param $urls
     * @param int $secret
     * @return array
     */
    public static function getUrls($urls, $secret = 0)
    {
        $ret = array();
        foreach ($urls as $k => $v) {
            $ret[$k] = PicUtil::getUrl($v, $secret);
        }
        return $ret;
    }

    /**
     * 获取图片地址
     * @param type $url 相对地址
     * @param type $secret 是否后台图片
     * @return string 地址
     */
    public static function getUrl($url, $secret = 0)
    {
        if (empty($url)) return '';
        if (strpos($url, 'http://') === 0) {
//            return FrontEnd::calcCDNDomain($url);
        }
        if ($secret == self::SECRET_ADMIN) {
//            return DOMAIN_IMG_SECRET . $url;
        } elseif ($secret == self::SECRET_IMAGES) {
//            return FrontEnd::calcCDNDomain('http://' . DOMAIN_RES . $url);
        } else {
//            return FrontEnd::calcCDNDomain(DOMAIN_IMG . $url);
        }
    }
}
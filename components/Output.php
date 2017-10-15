<?php
/**
 * Created by PhpStorm.
 * User: wangyi
 * Date: 2017/9/14
 * Time: 下午3:16
 */

namespace components;


use frontend\models\DataBus;
use yii\helpers\Html;

class Output
{
    public static $mimetypes = array(
        'ez' => 'application/andrew-inset',
        'hqx' => 'application/mac-binhex40',
        'cpt' => 'application/mac-compactpro',
        'doc' => 'application/msword',
        'bin' => 'application/octet-stream',
        'dms' => 'application/octet-stream',
        'lha' => 'application/octet-stream',
        'lzh' => 'application/octet-stream',
        'exe' => 'application/octet-stream',
        'class' => 'application/octet-stream',
        'so' => 'application/octet-stream',
        'dll' => 'application/octet-stream',
        'oda' => 'application/oda',
        'pdf' => 'application/pdf',
        'ai' => 'application/postscript',
        'eps' => 'application/postscript',
        'ps' => 'application/postscript',
        'smi' => 'application/smil',
        'smil' => 'application/smil',
        'mif' => 'application/vnd.mif',
        'xls' => 'application/vnd.ms-excel',
        'ppt' => 'application/vnd.ms-powerpoint',
        'wbxml' => 'application/vnd.wap.wbxml',
        'wmlc' => 'application/vnd.wap.wmlc',
        'wmlsc' => 'application/vnd.wap.wmlscriptc',
        'bcpio' => 'application/x-bcpio',
        'vcd' => 'application/x-cdlink',
        'pgn' => 'application/x-chess-pgn',
        'cpio' => 'application/x-cpio',
        'csh' => 'application/x-csh',
        'dcr' => 'application/x-director',
        'dir' => 'application/x-director',
        'dxr' => 'application/x-director',
        'dvi' => 'application/x-dvi',
        'spl' => 'application/x-futuresplash',
        'gtar' => 'application/x-gtar',
        'hdf' => 'application/x-hdf',
        'js' => 'application/x-javascript',
        'skp' => 'application/x-koan',
        'skd' => 'application/x-koan',
        'skt' => 'application/x-koan',
        'skm' => 'application/x-koan',
        'latex' => 'application/x-latex',
        'nc' => 'application/x-netcdf',
        'cdf' => 'application/x-netcdf',
        'sh' => 'application/x-sh',
        'shar' => 'application/x-shar',
        'swf' => 'application/x-shockwave-flash',
        'sit' => 'application/x-stuffit',
        'sv4cpio' => 'application/x-sv4cpio',
        'sv4crc' => 'application/x-sv4crc',
        'tar' => 'application/x-tar',
        'tcl' => 'application/x-tcl',
        'tex' => 'application/x-tex',
        'texinfo' => 'application/x-texinfo',
        'texi' => 'application/x-texinfo',
        't' => 'application/x-troff',
        'tr' => 'application/x-troff',
        'roff' => 'application/x-troff',
        'man' => 'application/x-troff-man',
        'me' => 'application/x-troff-me',
        'ms' => 'application/x-troff-ms',
        'ustar' => 'application/x-ustar',
        'src' => 'application/x-wais-source',
        'xhtml' => 'application/xhtml+xml',
        'xht' => 'application/xhtml+xml',
        'zip' => 'application/zip',
        'au' => 'audio/basic',
        'snd' => 'audio/basic',
        'mid' => 'audio/midi',
        'midi' => 'audio/midi',
        'kar' => 'audio/midi',
        'mpga' => 'audio/mpeg',
        'mp2' => 'audio/mpeg',
        'mp3' => 'audio/mpeg',
        'aif' => 'audio/x-aiff',
        'aiff' => 'audio/x-aiff',
        'aifc' => 'audio/x-aiff',
        'm3u' => 'audio/x-mpegurl',
        'ram' => 'audio/x-pn-realaudio',
        'rm' => 'audio/x-pn-realaudio',
        'rpm' => 'audio/x-pn-realaudio-plugin',
        'ra' => 'audio/x-realaudio',
        'wav' => 'audio/x-wav',
        'pdb' => 'chemical/x-pdb',
        'xyz' => 'chemical/x-xyz',
        'bmp' => 'image/bmp',
        'gif' => 'image/gif',
        'ief' => 'image/ief',
        'jpeg' => 'image/jpeg',
        'jpg' => 'image/jpeg',
        'jpe' => 'image/jpeg',
        'png' => 'image/png',
        'tiff' => 'image/tiff',
        'tif' => 'image/tiff',
        'djvu' => 'image/vnd.djvu',
        'djv' => 'image/vnd.djvu',
        'wbmp' => 'image/vnd.wap.wbmp',
        'ras' => 'image/x-cmu-raster',
        'pnm' => 'image/x-portable-anymap',
        'pbm' => 'image/x-portable-bitmap',
        'pgm' => 'image/x-portable-graymap',
        'ppm' => 'image/x-portable-pixmap',
        'rgb' => 'image/x-rgb',
        'xbm' => 'image/x-xbitmap',
        'xpm' => 'image/x-xpixmap',
        'xwd' => 'image/x-xwindowdump',
        'igs' => 'model/iges',
        'iges' => 'model/iges',
        'msh' => 'model/mesh',
        'mesh' => 'model/mesh',
        'silo' => 'model/mesh',
        'wrl' => 'model/vrml',
        'vrml' => 'model/vrml',
        'css' => 'text/css',
        'html' => 'text/html',
        'htm' => 'text/html',
        'asc' => 'text/plain',
        'txt' => 'text/plain',
        'rtx' => 'text/richtext',
        'rtf' => 'text/rtf',
        'sgml' => 'text/sgml',
        'sgm' => 'text/sgml',
        'tsv' => 'text/tab-separated-values',
        'wml' => 'text/vnd.wap.wml',
        'wmls' => 'text/vnd.wap.wmlscript',
        'etx' => 'text/x-setext',
        'xsl' => 'text/xml',
        'xml' => 'text/xml',
        'mpeg' => 'video/mpeg',
        'mpg' => 'video/mpeg',
        'mpe' => 'video/mpeg',
        'qt' => 'video/quicktime',
        'mov' => 'video/quicktime',
        'mxu' => 'video/vnd.mpegurl',
        'avi' => 'video/x-msvideo',
        'movie' => 'video/x-sgi-movie',
        'ice' => 'x-conference/x-cooltalk',
        '*' => 'application/octet-stream',
    );

    /**
     * 输出文件
     * @param $fileName
     * @param $filePath
     * @return bool
     */
    public static function file($fileName, $filePath)
    {
        if (!file_exists($filePath)) {

        }

        $pos = strrpos($fileName, '.');
        if ($pos !== false) {
            $suffix = substr($fileName, $pos + 1);
        } else {
            $suffix = '*';
        }
        $fileType = self::$mimetypes[$suffix];
        // send output to a browser
        header('Content-Type: ' . $fileType);
        header('Cache-Control: private, must-revalidate, post-check=0, pre-check=0, max-age=1');
        //header('Cache-Control: public, must-revalidate, max-age=0'); // HTTP/1.1
        header('Pragma: public');
        header('Expires: Sat, 26 Jul 1997 05:00:00 GMT'); // Date in the past
        header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT');
        header('Content-Disposition: inline; filename="' . $fileName . '"');
        $file = fopen($filePath, "r"); // 打开文件
        echo fread($file, filesize($filePath));
        fclose($file);
        return true;
    }

    public static function err($code, $msg, $data = array())
    {
        \Yii::error("err:" . DataBus::get('uid') . ".url:{$_SERVER['REQUEST_URI']}.code{$code}.msg:{$msg}.", 'echo');

        if (empty($data)) {
            $data = new \stdClass();
        }

        $tmpArr = [
            'code' => $code,
            'msg' => $msg,
            'data' => $data,
            'token' => DataBus::getToken(),
            'timestamp' => time()
        ];
        $tmpJson = json_encode($tmpArr);
        echo $tmpJson;
        exit();
    }

    public static function info($code, $msg, $data = array())
    {
        if (empty($data)) {
            $data = new \stdClass();
        }

        $tmpArr = [
            'code' => $code,
            'msg' => $msg,
            'data' => $data,
            'token' => DataBus::getToken(),
            'timestamp' => time()
        ];
        $tmpJson = json_encode($tmpArr);
        echo $tmpJson;
    }

    /**
     * 页面输出内容
     * @param $word
     * @param null $limit
     * @param string $etc
     */
    public static function kz_e($word, $limit = null, $etc = '...')
    {
        echo self::kz_v($word, $limit, $etc);
    }

    /**
     * 获得展示的内容,不输出
     * @param $word
     * @param null $limit
     * @param string $etc
     * @return string
     */
    public static function kz_v($word, $limit = null, $etc = '...')
    {
        $word = Html::encode($word);
        if ($limit !== null && is_numeric($limit)) {
            $len = mb_strlen($word, \Yii::$app->charset);
            if ($len > $limit) {
                $ret = mb_substr($word, 0, $limit, \Yii::$app->charset) . $etc;
            } else {
                $ret = $word;
            }
        } else {
            $ret = $word;
        }
        return $ret;
    }

    /**
     * 返回银行卡类似的格式
     * @param $cc
     * @param bool $hide 是否隐藏中间信息
     * @return string
     */
    public static function formatCreditCard($cc, $hide = true)
    {
        // REMOVE EXTRA DATA IF ANY
        $cc = str_replace(array('-', ' '), '', $cc);
        // GET THE CREDIT CARD LENGTH
        $cc_length = strlen($cc);
        $newCreditCard = substr($cc, -4);
        for ($i = $cc_length - 5; $i >= 0; $i--) {
            // ADDS HYPHEN HERE
            if ((($i + 1) - $cc_length) % 4 == 0) {
                $newCreditCard = '-' . $newCreditCard;
            }
            $newCreditCard = $cc[$i] . $newCreditCard;
        }
        // REPLACE CHARACTERS WITH X EXCEPT FIRST FOUR AND LAST FOUR
        if ($hide) {
            for ($i = 4; $i < $cc_length - 4; $i++) {
                if ($newCreditCard[$i] == '-') {
                    continue;
                }
                $newCreditCard[$i] = 'X';
            }
        }

        // RETURN THE FINAL FORMATED AND MASKED CREDIT CARD NO
        return $newCreditCard;
    }

    /**
     * 创建订单号
     * @return string
     */
    public static function orderid()
    {
        //订单号码主体（YYYYMMDDHHIISSNNNNNNNN）
        list($t1, $t2) = explode(' ', microtime());
        $msectime = (float)sprintf('%.0f', (floatval($t1) + floatval($t2)) * 1000);
        $order_id_main = date('YmdHis') . $msectime . rand(100000000, 999999999) . getmypid();
        //订单号码主体长度
        $order_id_len = strlen($order_id_main);
        $order_id_sum = 0;
        for ($i = 0; $i < $order_id_len; $i++) {
            $order_id_sum += (int)(substr($order_id_main, $i, 1));
        }
        //唯一订单号码（YYYYMMDDHHIISSNNNNNNNNCC）
        $order_id = $order_id_main . str_pad((100 - $order_id_sum % 100) % 100, 2, '0', STR_PAD_LEFT);

        return $order_id;
    }


}
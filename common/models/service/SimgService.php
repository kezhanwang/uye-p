<?php
/**
 * Created by PhpStorm.
 * User: wangyi
 * Date: 2017/10/16
 * Time: 下午6:20
 */

namespace common\models\service;


use common\models\ar\UyeSimg;
use components\PicUtil;
use components\UException;
use components\UrlUtil;
use frontend\models\DataBus;

class SimgService
{
    public static function encryptSimg($simgInfo, $round)
    {
        if (empty($simgInfo)) {
            return false;
        }

        $md5 = md5($simgInfo['path'] . $simgInfo['type'] . UyeSimg::SIMG_TOKEN . $round);

        return $md5;
    }

    public static function addSimgInfo($urls, $uid, $lid = 0, $sid = 0, $sbid = 0)
    {
        foreach ($urls as $key => $value) {
            $path = UrlUtil::urlForLinuxPath($value);
            list($null, $yearMonth, $day, $fileName) = explode('/', $path);
            $paySimg = array(
                'path' => $path,
                'year_month' => $yearMonth,
                'day' => $day,
                'file_name' => $fileName,
                'file_suffix' => PicUtil::getSuffix($fileName),
                'type' => UyeSimg::SIMG_TYPE_INSTALMENT,
            );
            try {
                $check = UyeSimg::getSimgByPath($path);
                if (!$check) {
                    UyeSimg::_insert($paySimg);
                }
            } catch (UException $exception) {
                \Yii::error(__LINE__ . ':' . __FUNCTION__ . DataBus::get('uid') . ':' . $exception->getMessage(), 'upload_files');
                continue;
            }
        }
        return true;
    }
}
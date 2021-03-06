<?php
/**
 * Created by PhpStorm.
 * User: wangyi
 * Date: 2017/10/13
 * Time: 下午2:53
 */

namespace common\models\ar;


use components\ArrayUtil;
use components\UException;

/**
 * Class UyeOrgWifi
 * @package common\models\ar
 * @property integer $created_time
 */
class UyeOrgWifi extends UActiveRecord
{
    const TABLE_NAME = 'uye_org_wifi';

    public static function tableName()
    {
        return self::TABLE_NAME;
    }

    public static function _add($info = array())
    {
        if (empty($info)) {
            return false;
        }

        $ar = new UyeOrgWifi();
        $ar->setIsNewRecord(true);
        $info = ArrayUtil::trimArray($info);
        $attrs = $ar->getAttributes();
        foreach ($attrs as $key => $attribute) {
            if (array_key_exists($key, $info)) {
                $ar->$key = $info[$key];
            }
        }
        $ar->created_time = time();

        if (!$ar->save()) {
            UException::dealAR($ar);
        }
        return $ar->getAttributes();
    }

    public static function _update($mac, $info)
    {
        if (empty($mac) || empty($info)) {
            return false;
        }
        $ar = self::findOne("mac='{$mac}'");
        foreach ($ar->getAttributes() as $key => $attribute) {
            if (array_key_exists($key, $info)) {
                $ar->$key = $info[$key];
            }
        }
        if (!$ar->save()) {
            UException::dealAR($ar);
        }
        return $ar->getAttributes();
    }

    public static function getByMacAndSSID($mac, $ssid, $ip, $org_id = 0)
    {
        if (empty($mac) || empty($ssid) || empty($ip)) {
            return false;
        }
        $mac = md5($mac);

//        $info = self::find()
//            ->select('*')
//            ->where("mac=':mac' AND ssid=':ssid'", [':mac' => $mac, ':ssid' => $ssid])
//            ->asArray()
//            ->all();

        $ar = new UyeOrgWifi();
        $info = $ar->findBySql("select * from ". self::TABLE_NAME. " WHERE mac = '{$mac}' AND ssid='{$ssid}'")->asArray()->one();
        if (empty($info)) {
            $info = self::_add(['mac' => $mac, 'ip' => $ip, 'ssid' => $ssid, 'org_id' => $org_id]);
        } else {
            if ($info['mac'] != $mac) {
                $info = self::_add(['mac' => $mac, 'ip' => $ip, 'ssid' => $ssid, 'org_id' => $org_id]);
            }
        }
        return $info;
    }
}
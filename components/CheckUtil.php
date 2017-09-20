<?php
/**
 * Created by PhpStorm.
 * User: wangyi
 * Date: 2017/9/14
 * Time: 下午4:17
 */

namespace components;

use Detection\MobileDetect;

require_once dirname(__FILE__) . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'vendor' . DIRECTORY_SEPARATOR . 'autoload.php';

class CheckUtil
{
    /**
     * 检查电话号码。1开头的11位数字，或者0开头的去掉-的11位以上数字
     * @param type $str
     */
    public static function phone($str)
    {
        $str = str_replace(array('-', ' '), '', $str);
        if (preg_match('/^0([0-9]{10,11})$/', $str) || preg_match('/^1([0-9]{10})$/', $str)) {
            $ret = true;
        } else {
            $ret = false;
        }
        return $ret;
    }

    /**
     * 检查手机号
     * @param type $phone
     * @return boolean
     */
    public static function checkPhone($phone)
    {
        if (!is_numeric($phone))
            return false;

        return preg_match('#^13[\d]{9}$|^14[\d]{9}$|^15[\d]{9}$|^17[\d]{9}$|^18[\d]{9}$#', $phone) ? true : false;
    }

    public static function checkFullName($full_name)
    {
        if (preg_match('/^([\xe4-\xe9][\x80-\xbf]{2}){2,10}$/', $full_name))
            return true;
        else
            return false;
    }

    public static function checkIDCard($vStr)
    {
        $vCity = array(
            '11', '12', '13', '14', '15', '21', '22',
            '23', '31', '32', '33', '34', '35', '36',
            '37', '41', '42', '43', '44', '45', '46',
            '50', '51', '52', '53', '54', '61', '62',
            '63', '64', '65', '71', '81', '82', '91'
        );

        if (!preg_match('/^([\d]{17}[xX\d]|[\d]{15})$/', $vStr)) return false;

        if (!in_array(substr($vStr, 0, 2), $vCity)) return false;

        $vStr = preg_replace('/[xX]$/i', 'a', $vStr);
        $vLength = strlen($vStr);

        if ($vLength == 18) {
            $vBirthday = substr($vStr, 6, 4) . '-' . substr($vStr, 10, 2) . '-' . substr($vStr, 12, 2);
        } else {
            $vBirthday = '19' . substr($vStr, 6, 2) . '-' . substr($vStr, 8, 2) . '-' . substr($vStr, 10, 2);
        }

        if (date('Y-m-d', strtotime($vBirthday)) != $vBirthday) return false;
        if ($vLength == 18) {
            $vSum = 0;

            for ($i = 17; $i >= 0; $i--) {
                $vSubStr = substr($vStr, 17 - $i, 1);
                $vSum += (pow(2, $i) % 11) * (($vSubStr == 'a') ? 10 : intval($vSubStr, 11));
            }

            if ($vSum % 11 != 1) return false;
        }
        return true;
    }

    public static function checkEmail($email)
    {
        $result = filter_var($email, FILTER_VALIDATE_EMAIL);
        if (!$result) {
            return false;
        } else {
            return true;
        }

    }

    public static function getNameLength($fullName)
    {
        return mb_strlen($fullName);
    }

    public static function getAgeByID($idCard)
    {
        if (empty($idCard)) return '';
        $birth_year = substr($idCard, 6, 4);
        $year = date('Y');
        $diff_year = $year - $birth_year;

        $birth_month = substr($idCard, 10, 2);
        $month = date('m');

        if ($month == $birth_month) {
            $birth_day = substr($idCard, 12, 2);
            $day = date('d');
            if ($birth_day > $day) {
                $age = $diff_year - 1;
            } else {
                $age = $diff_year;
            }
        } else if ($month > $birth_month) {
            $age = $diff_year;
        } else if ($month < $birth_month) {
            $age = $diff_year - 1;
        }
        return $age;
    }

    public static function getBirthday($idcard)
    {
        $string = substr($idcard, 6, 8);
        return date('Y-m-d', strtotime($string));
    }

    public static function checkIsMobile()
    {
        $detect = new \Mobile_Detect();
        if ($detect->isAndroidOS()) {
            $plat = 2;
        } else if ($detect->isIOS()) {
            $plat = 1;
        } else if ($detect->isMobile()) {
            $plat = 3;
        } else {
            $plat = 0;
        }
        return $plat;
    }


    public static function isPWD($value, $minLen = 8, $maxLen = 16)
    {
        $match = '/^[\\~!@#$%^&*()-_=+|{}\[\],.?\/:;\'\"\d\w]{' . $minLen . ',' . $maxLen . '}$/';
        $v = trim($value);
        if (empty($v)) {
            return false;
        }
        return preg_match($match, $v);
    }

}
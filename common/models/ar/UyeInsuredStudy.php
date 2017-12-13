<?php
/**
 * Created by PhpStorm.
 * User: wangyi
 * Date: 2017/12/12
 * Time: 下午5:17
 */

namespace common\models\ar;


use components\ArrayUtil;
use components\UException;

class UyeInsuredStudy extends UActiveRecord
{
    const TABLE_NAME = 'uye_insured_study';

    const STUDY_STATUS_STUDYING = 1;
    const STUDY_STATUS_GRADUATION = 2;
    const STUDY_STATUS_TRAINING = 3;

    public static $status = [
        self::STUDY_STATUS_STUDYING => '学习中',
        self::STUDY_STATUS_GRADUATION => '已毕业',
        self::STUDY_STATUS_TRAINING => '再培训'
    ];

    const ADD_TYPE_USER = 1;
    const ADD_TYPE_ORG = 2;

    public static $addType = [
        self::ADD_TYPE_USER => '用户添加',
        self::ADD_TYPE_ORG => '机构添加'
    ];

    const RANKING_D = 1;
    const RANKING_C = 2;
    const RANKING_B = 3;
    const RANKING_A = 4;

    public static $ranking = [
        self::RANKING_D => '较差',
        self::RANKING_C => '一般',
        self::RANKING_B => '良好',
        self::RANKING_A => '优秀'
    ];

    public static function tableName()
    {
        return self::TABLE_NAME;
    }

    public static function _add($info = array())
    {
        if (empty($info)) {
            return false;
        }

        $info = ArrayUtil::trimArray($info);
        $ar = new  UyeInsuredStudy();
        $ar->setIsNewRecord(true);
        foreach ($ar->getAttributes() as $key => $attribute) {
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
}
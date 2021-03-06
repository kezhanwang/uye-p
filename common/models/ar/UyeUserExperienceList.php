<?php
/**
 * Created by PhpStorm.
 * User: wangyi
 * Date: 2017/10/30
 * Time: 下午3:55
 */

namespace common\models\ar;


use components\ArrayUtil;
use components\UException;

class UyeUserExperienceList extends UActiveRecord
{
    const TABLE_NAME = 'uye_user_experience_list';

    const TYPE_STUDY = 1;
    const TYPE_WORK = 2;

    const STATUS_ON = 1;
    const STATUS_OFF = 2;

    public static $type = [
        self::TYPE_STUDY => '学历',
        self::TYPE_WORK => '职业'
    ];

    public static $status = [
        self::STATUS_ON => '可用',
        self::STATUS_OFF => '不可用'
    ];

    public static function tableName()
    {
        return self::TABLE_NAME;
    }

    public static function getByUid($uid, $type = '')
    {
        $query = self::find()
            ->select('*')
            ->from(self::TABLE_NAME)
            ->where('uid=:uid AND status=:status', [':uid' => $uid, ':status' => self::STATUS_ON]);

        if ($type) {
            $query->andWhere('type=:type', [':type' => $type]);
        }
        $list = $query->asArray()->all();
        if (empty($list)) {
            return [];
        } else {
            return $list;
        }
    }

    public static function getByID($id)
    {
        $info = self::find()
            ->select('*')
            ->from(self::TABLE_NAME)
            ->where('id=:id', [':id' => $id])
            ->asArray()->one();
        if (empty($info)) {
            return [];
        } else {
            return $info;
        }
    }

    public static function _update($id, $info)
    {
        $ar = self::findOne($id);

        $info = ArrayUtil::trimArray($info);

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

    public static function _add($info)
    {
        if (empty($info)) {
            return false;
        }

        $ar = new UyeUserExperienceList();
        $info = ArrayUtil::trimArray($info);
        foreach ($ar->getAttributes() as $key => $attribute) {
            if (array_key_exists($key, $info)) {
                $ar->$key = $info[$key];
            }
        }
        $ar->created_time = time();
        $ar->updated_time = time();

        if (!$ar->save()) {
            UException::dealAR($ar);
        }

        return $ar->getAttributes();
    }

}
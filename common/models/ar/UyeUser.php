<?php
/**
 * Created by PhpStorm.
 * User: wangyi
 * Date: 2017/9/18
 * Time: 上午10:27
 */

namespace common\models\ar;


use components\ArrayUtil;
use components\UException;

class UyeUser extends UActiveRecord
{
    const TABLE_NAME = 'uye_user';

    const STATUS_NORMAL = 1;
    const STATUS_CLOSE = 2;
    const STATUS_BLACKLIST = 3;


    public static function tableName()
    {
        return self::TABLE_NAME; // TODO: Change the autogenerated stub
    }

    /**
     * @param null $phone
     * @return static
     * @throws UException
     */
    public static function getUserByPhone($phone = null)
    {
        if (is_null($phone)) {
            throw new UException(ERROR_SYS_PARAMS_CONTENT, ERROR_SYS_PARAMS);
        }

        $result = static::findOne(['phone' => $phone]);
        return $result;
    }

    /**
     * @param null $phone
     * @param null $password
     * @return static
     * @throws UException
     */
    public static function getUserByLogin($phone = null, $password = null)
    {
        if (is_null($phone) || is_null($password)) {
            throw new UException(ERROR_SYS_PARAMS_CONTENT, ERROR_SYS_PARAMS);
        }

        $userInfo = static::findOne(['phone' => $phone, 'password' => $password]);
        return $userInfo;
    }

    /**
     * @param $uid
     * @return static
     * @throws UException
     */
    public static function getUserByUid($uid)
    {
        if (is_null($uid) || !is_numeric($uid)) {
            throw new UException(ERROR_SYS_PARAMS_CONTENT, ERROR_SYS_PARAMS);
        }

        $userInfo = static::findOne(['uid' => $uid]);
        return $userInfo;
    }

    /**
     * @param $uid
     * @return static
     * @throws UException
     */
    public static function getUserByUidAndPassword($uid, $password)
    {
        if (is_null($uid) || !is_numeric($uid) || is_null($password)) {
            throw new UException(ERROR_SYS_PARAMS_CONTENT, ERROR_SYS_PARAMS);
        }

        $userInfo = static::findOne(['uid' => $uid, 'password' => $password]);
        return $userInfo;
    }

    /**
     * @param array $info
     * @return array
     * @throws UException
     */
    public static function _addUser($info = array())
    {
        if (empty($info)) {
            throw new UException(ERROR_SYS_PARAMS_CONTENT, ERROR_SYS_PARAMS);
        }

        $ar = new UyeUser();
        $ar->setIsNewRecord(true);
        $attributes = $ar->getAttributes();
        $info = ArrayUtil::trimArray($info);
        foreach ($attributes as $key => $item) {
            if (!empty($info[$key])) {
                $ar->$key = $info[$key];
            }
        }

        if (!$ar->save()) {
            throw new UException(var_export($ar->getErrors(), true), ERROR_DB);
        }

        return $ar->getAttributes();
    }

    /**
     * @param $uid
     * @param $info
     * @return array
     * @throws UException
     */
    public static function _updateUser($uid, $info)
    {
        if (empty($info) || !is_numeric($uid) || is_null($uid)) {
            throw new UException(ERROR_SYS_PARAMS_CONTENT, ERROR_SYS_PARAMS);
        }

        $ar = self::findOne(['uid' => $uid]);
        $attributes = $ar->getAttributes();
        $info = ArrayUtil::trimArray($info);
        foreach ($attributes as $key => $attribute) {
            if (!empty($info[$key])) {
                $ar->$key = $info[$key];
            }
        }

        $ar->updated_time = time();

        if (!$ar->save()) {
            throw new UException(var_export($ar->getErrors(), true), ERROR_DB);
        }
        return $ar->getAttributes();

    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'uid' => '用户uid',
            'username' => '昵称',
            'password' => '密码',
            'phone' => '手机号',
            'email' => '邮箱',
            'status' => '状态',
            'head_portrait' => '头像',
            'created_time' => '注册时间',
            'updated_time' => '更新时间',
        ];
    }
}
<?php
/**
 * Created by PhpStorm.
 * User: wangyi
 * Date: 2017/10/12
 * Time: 下午5:58
 */

namespace common\models\ar;


use components\ArrayUtil;
use components\UException;

/**
 * This is the model class for table "uye_user_identity".
 *
 * @property integer $uid
 * @property string $full_name
 * @property string $id_card
 * @property string $id_card_start
 * @property string $id_card_end
 * @property string $id_card_address
 * @property string $id_card_info_pic
 * @property string $id_card_nation_pic
 * @property string $auth_mobile
 * @property string $bank_card_number
 * @property string $open_bank
 * @property integer $created_time
 * @property integer $updated_time
 *
 * @property UyeUser $u
 */
class UyeUserIdentity extends UActiveRecord
{
    const TABLE_NAME = 'uye_user_identity';

    public static function tableName()
    {
        return self::TABLE_NAME;
    }

    public static function _add($info = array())
    {
        if (empty($info)) {
            throw new UException(ERROR_SYS_PARAMS_CONTENT, ERROR_SYS_PARAMS);
        }

        $ar = new UyeUserIdentity();
        $ar->setIsNewRecord(true);
        $info = ArrayUtil::trimArray($info);
        foreach ($ar->getAttributes() as $key => $value) {
            if (isset($info[$key])) {
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

    public static function _update($uid, $info)
    {
        if (empty($uid) || empty($info) || !is_numeric($uid)) {
            throw new UException(ERROR_SYS_PARAMS_CONTENT, ERROR_SYS_PARAMS);
        }

        $ar = self::findOne($uid);
        $info = ArrayUtil::trimArray($info);

        foreach ($ar->getAttributes() as $key => $value) {
            if (isset($info[$key])) {
                $ar->$key = $info[$key];
            }
        }
        $ar->updated_time = time();

        if (!$ar->save()) {
            UException::dealAR($ar);
        }

        return $ar->getAttributes();
    }
}
<?PHP
/**
 * Created by PhpStorm.
 * User: wangyi
 * Date: 2017/10/17
 * Time: 下午5:19
 */

namespace common\models\ar;


use components\UException;

class UyeInsuredLog extends UActiveRecord
{
    const TABLE_NAME = "uye_insured_log";

    public static function tableName()
    {
        return self::TABLE_NAME;
    }

    public static function _addLog($insuredID, $insuredOrder, $statusBefore, $statusAfter, $uid, $change, $remark)
    {
        $ar = new UyeInsuredLog();
        $ar->setIsNewRecord(true);
        $ar->insured_id = $insuredID;
        $ar->insured_order = $insuredOrder;
        $ar->status_before = $statusBefore;
        $ar->status_after = $statusAfter;
        $ar->op_uid = $uid;
        $ar->change = $change;
        $ar->remark = $remark;
        $ar->created_time = time();

        if (!$ar->save()) {
            UException::dealAR($ar);
        }

        return $ar->getAttributes();
    }
}
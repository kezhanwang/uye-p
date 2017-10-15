<?php
/**
 * Created by PhpStorm.
 * User: wangyi
 * Date: 2017/10/11
 * Time: 下午3:26
 */

namespace app\modules\app\actions;


use app\modules\app\components\AppAction;
use common\models\ar\UyeUserIdentity;
use components\Output;
use components\UException;
use frontend\models\DataBus;

class UserinfoAction extends AppAction
{
    public function run()
    {
        try {
            $uid = DataBus::get('uid');
            $uid=1000000;
            $identity = $this->identity($uid);

            $templateData = [
                'identity' => $identity,
            ];
            Output::info(SUCCESS, SUCCESS_CONTENT, $templateData);
        } catch (UException $exception) {
            Output::err($exception->getCode(), $exception->getMessage());
        }
    }

    private function identity($uid)
    {
        $userIdentity = UyeUserIdentity::find()->select('*')->where('uid=:uid', [':uid' => $uid])->asArray()->one();
        if (empty($userIdentity)) {
            return false;
        }

        $params = ['full_name', 'id_card', 'id_card_start', 'id_card_end', 'id_card_address', 'id_card_info_pic', 'id_card_nation_pic', 'auth_mobile', 'bank_card_number', 'open_bank_code', 'open_bank'];

        $result = true;
        foreach ($params as $param) {
            if (!array_key_exists($param, $userIdentity) || empty($userIdentity[$param])) {
                $result = false;
                break;
            }
        }
        return $result;
    }

}
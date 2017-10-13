<?php
/**
 * Created by PhpStorm.
 * User: wangyi
 * Date: 2017/10/12
 * Time: 下午7:14
 */

namespace app\modules\app\actions;


use app\modules\app\components\AppAction;
use common\models\ar\UyeUserIdentity;
use components\Output;
use components\SmsUtil;
use components\UException;
use frontend\models\DataBus;

class IdentityAction extends AppAction
{
    public function run()
    {
        try {
            $uid = DataBus::get('uid');
            $request = \Yii::$app->request;
            $ip = $request->getUserIP();
            $params = $request->isPost ? $request->post() : $request->get();

            $checkParams = ['full_name', 'id_card', 'id_card_start', 'id_card_end', 'id_card_address', 'id_card_info_pic', 'id_card_nation_pic', 'auth_mobile', 'bank_card_number', 'open_bank_code', 'code'];

            foreach ($checkParams as $checkParam) {
                if (array_key_exists($checkParam, $params)) {
                    throw new UException(ERROR_SYS_PARAMS_CONTENT, ERROR_SYS_PARAMS);
                }
            }

            SmsUtil::checkVerifyCode($params['phone'], $ip, $params['code']);

            $userIdentity = UyeUserIdentity::find()->select('*')->where('uid=:uid', [':uid' => $uid])->asArray()->one();
            if (empty($userIdentity)) {
                $params['uid'] = $uid;
                $userIdentity = UyeUserIdentity::_add($params);
            }

            $diffArr = [];
            foreach ($params as $key => $param) {
                if ($param != $userIdentity[$key]) {
                    $diffArr[$key] = $param;
                }
            }

            if (!empty($diffArr)) {
                UyeUserIdentity::_update($uid, $diffArr);
            }
            Output::info(SUCCESS, SUCCESS_CONTENT);
        } catch (UException $exception) {
            Output::err($exception->getCode(), $exception->getMessage(), [], DataBus::get('uid'));
        }
    }
}
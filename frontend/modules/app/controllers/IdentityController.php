<?php
/**
 * Created by PhpStorm.
 * User: wangyi
 * Date: 2017/10/12
 * Time: 下午5:25
 */

namespace app\modules\app\controllers;


use app\modules\app\components\AppController;
use common\models\ar\UyeConfig;
use common\models\ar\UyeUserAuth;
use common\models\ar\UyeUserIdentity;
use components\Output;
use components\RedisUtil;
use components\UException;
use frontend\models\DataBus;

class IdentityController extends AppController
{
    public function init()
    {
        parent::init(); // TODO: Change the autogenerated stub
        if ($this->isMobile) {
            $this->checkLogin();
        } else {
            $this->checkLogin(true);
        }
    }

    public function actions()
    {
        return [
            'submit' => [
                'class' => "app\modules\app\actions\IdentityAction"
            ],
        ];
    }

    public function actionInfo()
    {
        try {
            $uid = DataBus::get('uid');
            if (empty($uid)) {
                throw new UException(ERROR_USER_INFO_NO_EXISTS_CONTENT, ERROR_USER_INFO_NO_EXISTS_CONTENT);
            }
            $userIdentity = UyeUserIdentity::find()->select('*')->where('uid=:uid', [':uid' => $uid])->asArray()->one();

            if (empty($userIdentity)) {
                $userIdentity = UyeUserIdentity::_add(['uid' => $uid]);
            }
            Output::info(SUCCESS, SUCCESS_CONTENT, $userIdentity);
        } catch (UException $exception) {
            Output::err($exception->getCode(), $exception->getMessage());
        }
    }

    public function actionConfig()
    {
        try {
//            $redis = RedisUtil::getInstance();
//            $redisKey = 'UYE-OPEN-BANK-CONFIG';
//            $data = $redis->get($redisKey);
//            if ($data) {
//                $data = json_decode($data, true);
//            } else {
//                $config = UyeConfig::find()->select('value')->where('name=:name', [':name' => 'open_bank'])->asArray()->one();
//                if ($config) {
//                    $data = json_decode($config['value'], true);
//                } else {
            $data = [
                ['open_bank_code' => 'ICBC', 'open_bank' => '中国工商银行', 'icon' => DOMAIN_IMAGE . "/201710/19/icbc.png"],
                ['open_bank_code' => 'ABC', 'open_bank' => '中国农业银行', 'icon' => DOMAIN_IMAGE . "/201710/19/abc.png"],
                ['open_bank_code' => 'CCB', 'open_bank' => '中国建设银行', 'icon' => DOMAIN_IMAGE . "/201710/19/ccb.png"],
                ['open_bank_code' => 'BOC', 'open_bank' => '中国银行', 'icon' => DOMAIN_IMAGE . "/201710/19/boc.png"],
                ['open_bank_code' => 'BCOM', 'open_bank' => '中国交通银行', 'icon' => DOMAIN_IMAGE . "/201710/19/bcom.png"],
                ['open_bank_code' => 'CIB', 'open_bank' => '兴业银行', 'icon' => DOMAIN_IMAGE . "/201710/19/cib.png"],
                ['open_bank_code' => 'CITIC', 'open_bank' => '中信银行', 'icon' => DOMAIN_IMAGE . "/201710/19/citic.png"],
                ['open_bank_code' => 'CEB', 'open_bank' => '中国光大银行', 'icon' => DOMAIN_IMAGE . "/201710/19/ceb.png"],
                ['open_bank_code' => 'PAB', 'open_bank' => '平安银行', 'icon' => DOMAIN_IMAGE . "/201710/19/pab.png"],
                ['open_bank_code' => 'PSBC', 'open_bank' => '中国邮政储蓄银行', 'icon' => DOMAIN_IMAGE . "/201710/19/psbc.png"],
                ['open_bank_code' => 'SHB', 'open_bank' => '上海银行', 'icon' => DOMAIN_IMAGE . "/201710/19/shb.png"],
                ['open_bank_code' => 'SPDB', 'open_bank' => '浦东发展银行', 'icon' => DOMAIN_IMAGE . "/201710/19/spdb.png"],
                ['open_bank_code' => 'CMBC', 'open_bank' => '民生银行', 'icon' => DOMAIN_IMAGE . "/201710/19/cmbc.png"],
                ['open_bank_code' => 'CMB', 'open_bank' => '招商银行', 'icon' => DOMAIN_IMAGE . "/201710/19/cmb.png"],
                ['open_bank_code' => 'GDB', 'open_bank' => '广发银行', 'icon' => DOMAIN_IMAGE . "/201710/19/gdb.png"],
                ['open_bank_code' => 'HXB', 'open_bank' => '华夏银行', 'icon' => DOMAIN_IMAGE . "/201710/19/hxb.png"],
            ];
//            UyeConfig::_addConfig(['name' => 'open_bank', 'label' => '开户行', 'value' => json_encode($data)]);
//                }
//            $redis->set($redisKey, json_encode($data));
//            }
            Output::info(SUCCESS, SUCCESS_CONTENT, $data);
        } catch (UException $exception) {
            Output::err($exception->getCode(), $exception->getMessage());
        }
    }

    public function actionPic()
    {
        try {
            $udcredit_order = $this->getParams('udcredit_order');
            if (empty($udcredit_order)) {
                throw new UException();
            }

            $userInfo = UyeUserAuth::getUserInfoByOrder($udcredit_order);
            if (empty($userInfo)) {
                $data = [
                    'id_card_info_pic' => '',
                    'id_card_nation_pic' => '',
                ];
            } else {
                $data = [
                    'id_card_info_pic' => DOMAIN_SECRET . $userInfo['front_card'],
                    'id_card_nation_pic' => DOMAIN_SECRET . $userInfo['back_card'],
                ];
            }

            Output::info(SUCCESS, SUCCESS_CONTENT, $data);
        } catch (UException $exception) {
            Output::err($exception->getCode(), $exception->getMessage());
        }
    }
}
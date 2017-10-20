<?php
/**
 * Created by PhpStorm.
 * User: wangyi
 * Date: 2017/10/13
 * Time: 下午4:49
 */

namespace app\modules\app\controllers;


use app\modules\app\components\AppController;
use common\models\ar\UyeUserMobile;
use components\Output;
use components\UException;
use frontend\models\DataBus;

class MobileController extends AppController
{
    public function init()
    {
        parent::init(); // TODO: Change the autogenerated stub
        $this->checkLogin();
        $str = [
            ['Email' => '', 'FirstName' => '1', 'LastName' => '2', 'Phones' => ['111']]
        ];
//        var_dump(json_encode($str));
//        exit;
    }

    public function actionSubmit()
    {
        try {
            $mobiles = $this->getParams('mobile');
            $mobilesArr = json_decode($mobiles, true);
            $rows = [];
            foreach ($mobilesArr as $item) {
                $tmp = array(
                    'firstname' => empty($item['FirstName']) ? $item['a'] : $item['FirstName'],
                    'lastname' => empty($item['LastName']) ? $item['b'] : $item['LastName'],
                );
                $tmp['email'] = ((isset($item['Email']) && $item['Email']) ? array_shift($item['Email']) : $item['d']);
                if (empty($item['Phones'])) {
                    $item['Phones'] = $item['c'];
                }
                for ($i = 0; $i < 3; $i++) {
                    $k = 'mobile' . ($i + 1);
                    if (isset($item['Phones']) && $item['Phones'] && array_key_exists($i, $item['Phones'])) {
                        $tmp[$k] = $item['Phones'][$i];
                    } else {
                        $tmp[$k] = '';
                    }
                }
                $rows[] = $tmp;
            }
            UyeUserMobile::_update(DataBus::get('uid'), [
                'list' => json_encode($rows),
                'count' => count($rows),
                'app_type' => DataBus::get('plat')
            ]);
            Output::info(SUCCESS, SUCCESS_CONTENT);
        } catch (UException $exception) {
            Output::err($exception->getCode(), $exception->getMessage());
        }
    }
}
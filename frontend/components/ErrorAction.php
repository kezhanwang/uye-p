<?php
/**
 * Created by PhpStorm.
 * User: wangyi
 * Date: 2017/10/31
 * Time: 下午2:38
 */

namespace app\components;


use components\Output;
use frontend\models\DataBus;
use yii\base\Action;

class ErrorAction extends \yii\web\ErrorAction
{
    public function run()
    {
        \Yii::$app->getResponse()->setStatusCodeByException($this->exception);
        $plat = DataBus::get('plat');
        if (!$plat) {
            return parent::run();
        }else{
            $data = [
                'name' => $this->getExceptionName(),
                'message' => $this->getExceptionMessage(),
                'exception' => $this->exception,
            ];
            Output::err($data['exception']->statusCode, $data['message']);
        }
    }
}
<?php
/**
 * Created by PhpStorm.
 * User: wangyi
 * Date: 2017/9/22
 * Time: 下午3:54
 */

namespace e\components;

use Yii;
use yii\web\Controller;

class UAdminController extends Controller
{
    public function init()
    {
        parent::init(); // TODO: Change the autogenerated stub
        if (Yii::$app->user->isGuest) {
            return $this->redirect(['/site/login']);
        }
    }


}
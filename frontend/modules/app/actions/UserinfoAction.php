<?php
/**
 * Created by PhpStorm.
 * User: wangyi
 * Date: 2017/10/11
 * Time: 下午3:26
 */

namespace app\modules\app\actions;


use app\modules\app\components\AppAction;

class UserinfoAction extends AppAction
{
    public function init()
    {
        parent::init(); // TODO: Change the autogenerated stub
        $this->checkLogin();
    }

    public function run()
    {

    }
}
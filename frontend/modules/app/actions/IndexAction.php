<?php
/**
 * Created by PhpStorm.
 * User: wangyi
 * Date: 2017/10/9
 * Time: 上午11:36
 */

namespace app\modules\app\actions;


use app\modules\app\components\AppAction;
use components\Output;
use components\UException;

class IndexAction extends AppAction
{
    public function run()
    {
        try {

        } catch (UException $exception) {
            Output::err($exception->getCode(), $exception->getMessage());
        }
    }
}
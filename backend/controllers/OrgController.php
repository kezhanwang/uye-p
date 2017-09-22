<?php
/**
 * Created by PhpStorm.
 * User: wangyi
 * Date: 2017/9/22
 * Time: 下午2:50
 */

namespace backend\controllers;


use backend\components\UAdminController;

class OrgController extends UAdminController
{
    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionList()
    {
        return $this->render('list');
    }

    public function actionEdit()
    {
        return $this->render('edit');
    }
}
<?php
/**
 * Created by PhpStorm.
 * User: wangyi
 * Date: 2017/9/22
 * Time: 下午4:18
 */

namespace backend\controllers;


use backend\components\UAdminController;

class CourseController extends UAdminController
{
    public function actionIndex()
    {
        return $this->render('index');
    }
}
<?php

namespace app\controllers;


use frontend\components\UController;

class LoginController extends UController
{
    public function actionIndex()
    {
        return $this->render('index');
    }

}

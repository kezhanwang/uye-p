<?php

namespace app\modules\e\controllers;

use yii\web\Controller;

/**
 * Default controller for the `e` module
 */
class DefaultController extends Controller
{
    public $layout = "main";

    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionLogin()
    {
        return $this->render('login');
    }
}

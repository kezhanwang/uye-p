<?php

namespace app\modules\app\controllers;

use app\modules\app\components\AppController;
use yii\web\Controller;

/**
 * Default controller for the `app` module
 */
class DefaultController extends AppController
{
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }
}

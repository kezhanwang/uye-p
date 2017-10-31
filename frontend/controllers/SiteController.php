<?php

namespace frontend\controllers;

use frontend\components\UController;


/**
 * Site controller
 */
class SiteController extends UController
{

    public function actions()
    {
        return [
            'error' => [
                'class' => 'app\components\ErrorAction',
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return mixed
     */
    public function actionIndex()
    {
        return $this->render('index');
    }
}

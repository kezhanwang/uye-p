<?php
namespace frontend\controllers;

use frontend\components\UController;


/**
 * Site controller
 */
class SiteController extends UController
{
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

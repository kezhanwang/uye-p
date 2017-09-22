<?php
namespace backend\controllers;

use backend\components\UAdminController;


/**
 * Site controller
 */
class SiteController extends UAdminController
{

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

}

<?php
/**
 * Created by PhpStorm.
 * User: wangyi
 * Date: 2017/10/20
 * Time: 上午10:28
 */

namespace e\controllers;


use e\components\EController;

class SiteController extends EController
{
    public function init()
    {
        parent::init(); // TODO: Change the autogenerated stub
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    public function actionIndex()
    {
        return $this->render('index');
    }
}
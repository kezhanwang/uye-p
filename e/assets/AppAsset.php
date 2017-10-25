<?php

namespace e\assets;

use yii\web\AssetBundle;

/**
 * Main backend application asset bundle.
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/style.css',
        'css/style-responsive.css',
        'js/nprogress/nprogress.css',
        'css/clndr.css'
    ];
    public $js = [
        'js/jquery-1.10.2.min.js',
        'js/jquery-ui-1.9.2.custom.min.js',
        'js/jquery-migrate-1.2.1.min.js',
        'js/bootstrap.min.js',
        'js/modernizr.min.js',
        'js/jquery.nicescroll.js',
        'js/nprogress/nprogress.js',
        'js/scripts.js',
        'js/alter.js'
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];

    //定义按需加载JS方法，注意加载顺序在最后
    public static function addJs($view, $jsfile)
    {
        $view->registerJsFile(
            $jsfile,
            [
                AppAsset::className(),
                "depends" => "e\assets\AppAsset"
            ]
        );
    }

    //定义按需加载css方法，注意加载顺序在最后
    public static function addCss($view, $cssfile)
    {
        $view->registerCssFile(
            $cssfile,
            [
                AppAsset::className(),
                "depends" => "e\assets\AppAsset"
            ]
        );
    }
}

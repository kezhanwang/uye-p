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
        'css/clndr.css'
    ];
    public $js = [
        'js/jquery-1.10.2.min.js',
        'js/jquery-ui-1.9.2.custom.min.js',
        'js/jquery-migrate-1.2.1.min.js',
        'js/bootstrap.min.js',
        'js/modernizr.min.js',
        'js/jquery.nicescroll.js',
        'js/scripts.js'
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}

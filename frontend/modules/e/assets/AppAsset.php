<?php
/**
 * Created by PhpStorm.
 * User: wangyi
 * Date: 2017/10/18
 * Time: 下午4:55
 */

namespace app\modules\e\assets;


use yii\web\AssetBundle;

class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'e/css/style.css',
        'e/css/style-responsive.css',
        'e/css/clndr.css',
    ];
    public $js = [
        'e/js/jquery-1.10.2.min.js',
        'e/js/jquery-ui-1.9.2.custom.min.js',
        'e/js/jquery-migrate-1.2.1.min.js',
        'e/js/bootstrap.min.js',
        'e/js/modernizr.min.js',
        'e/js/jquery.nicescroll.js',

        'e/js/scripts.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}
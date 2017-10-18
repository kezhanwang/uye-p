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
    public $basePath = '@static/e';
    public $baseUrl = '@web';
    public $css = [
        'css/site.css',
        'css/style-responsive.css',
        'css/clndr.css',
    ];
    public $js = [
        'js/jquery-1.10.2.min.js',
        'js/jquery-ui-1.9.2.custom.min.js',
        'js/jquery-migrate-1.2.1.min.js',
        'js/bootstrap.min.js',
        'js/modernizr.min.js',
        'js/jquery.nicescroll.js',

        'js/scripts.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}
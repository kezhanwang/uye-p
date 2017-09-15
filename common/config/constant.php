<?php
/**
 * Created by PhpStorm.
 * User: wangyi
 * Date: 2017/9/15
 * Time: 上午10:30
 */
/**
 * 定义系统常量
 */
define('PATH_BASE', dirname(__FILE__) . DIRECTORY_SEPARATOR . "..");
define('PATH_COMMON_CONFIG', PATH_BASE . DIRECTORY_SEPARATOR . 'config');


/**
 * 域名定义
 */
define('DOMAIN_BASE', 'bjzhongteng.com');   //顶级域名
if (YII_ENV == 'dev' || YII_ENV == 'test') {
    define('DOMAIN_E', 'dev.e.' . DOMAIN_BASE);     //二级域名，机构管理平台，开发环境
    define('DOMAIN_ADMIN', 'dev.admin.' . DOMAIN_BASE); //二级域名，运营平台，开发环境
    define('DOMAIN_APP', 'dev.app.' . DOMAIN_BASE); //二级域名，APP接口，开发环境
} else {
    define('DOMAIN_E', 'e.' . DOMAIN_BASE); //二级域名，机构管理平台，生产环境
    define('DOMAIN_ADMIN', 'admin.' . DOMAIN_BASE); //二级域名，运营平台，生产环境
    define('DOMAIN_APP', 'app.' . DOMAIN_BASE); //二级域名，APP接口，生产环境
}

echo YII_ENV;


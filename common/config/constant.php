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
define('PATH_UPLOAD', PATH_BASE . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'upload');
define('PATH_UPLOAD_VCODE', PATH_UPLOAD . DIRECTORY_SEPARATOR . 'vcode');
define('PATH_UPLOAD_SECRET', '');

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

define('USER_PASSWORD_STR', 'BJZHONGTENG');


/**
 * 定义一些排序的宏
 */
define('SORT_DB_DESC', 'DESC');
define('SORT_DB_ASC', 'ASC');

define('SORT_DEFAULT', '');                  //无排序
define('SORT_FOCUS', 'num_focus');           //按关注数
define('SORT_ORDER', 'num_order');           //按报名数
define('SORT_SCORE', 'score');           //按评分
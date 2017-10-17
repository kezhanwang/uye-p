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
define('PATH_LIBRARIES', PATH_BASE . DIRECTORY_SEPARATOR . ".." . DIRECTORY_SEPARATOR . "libraries");
define('PATH_VENDOR', PATH_BASE . DIRECTORY_SEPARATOR . ".." . DIRECTORY_SEPARATOR . "vendor");
define('PATH_UPLOAD', PATH_BASE . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'upload');
define('PATH_UPLOAD_VCODE', PATH_UPLOAD . DIRECTORY_SEPARATOR . 'vcode');
define('PATH_UPLOAD_SECRET', PATH_UPLOAD . DIRECTORY_SEPARATOR . "data" . DIRECTORY_SEPARATOR . "secret");
define('PATH_UPLOAD_IMAGE', PATH_UPLOAD . DIRECTORY_SEPARATOR . "image");

/**
 * 域名定义
 */
define('DOMAIN_BASE', 'bjzhongteng.com');   //顶级域名
if (YII_ENV == 'dev' || YII_ENV == 'test') {
    define('DOMAIN_HTTPS', 'http://');
    define('DOMAIN_E', DOMAIN_HTTPS . 'dev.e.' . DOMAIN_BASE);     //二级域名，机构管理平台，开发环境
    define('DOMAIN_ADMIN', DOMAIN_HTTPS . 'dev.admin.' . DOMAIN_BASE); //二级域名，运营平台，开发环境
    define('DOMAIN_APP', DOMAIN_HTTPS . 'dev.app.' . DOMAIN_BASE); //二级域名，APP接口，开发环境
    define('DOMAIN_IMAGE', DOMAIN_HTTPS . 'dev.img' . DOMAIN_BASE);    //二级域名，图片资源
    define('DOMAIN_SECRET', DOMAIN_HTTPS . 'dev.simg' . DOMAIN_BASE);    //二级域名，个人图片资源
} else {
    define('DOMAIN_HTTPS', 'https://');
    define('DOMAIN_E', DOMAIN_HTTPS . 'e.' . DOMAIN_BASE); //二级域名，机构管理平台，生产环境
    define('DOMAIN_ADMIN', DOMAIN_HTTPS . 'admin.' . DOMAIN_BASE); //二级域名，运营平台，生产环境
    define('DOMAIN_APP', DOMAIN_HTTPS . 'app.' . DOMAIN_BASE); //二级域名，APP接口，生产环境
    define('DOMAIN_IMAGE', DOMAIN_HTTPS . 'img' . DOMAIN_BASE);    //二级域名，图片资源
    define('DOMAIN_SECRET', DOMAIN_HTTPS . 'simg' . DOMAIN_BASE);    //二级域名，个人图片资源
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
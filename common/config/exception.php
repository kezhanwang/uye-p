<?php
/**
 * Created by PhpStorm.
 * User: wangyi
 * Date: 2017/9/18
 * Time: 下午2:21
 */
/**
 * 成功
 */
define('SUCCESS', 1000);
define('SUCCESS_CONTENT', '操作成功');

define('ERROR_SYS_PARAMS', 1001);
define('ERROR_SYS_PARAMS_CONTENT', '系统参数异常');

define('ERROR_PHONE_FORMAT', 1002);
define('ERROR_PHONE_FORMAT_CONTENT', '手机号格式错误');

define('ERROR_VCODE', 1003);
define('ERROR_VCODE_CONTENT', '图形验证码异常');

define('ERROR_LOGIN_NO_USERINFO', 1004);
define('ERROR_LOGIN_NO_USERINFO_CONTENT', '用户名或密码错误');

define('ERROR_REGISTER_PHONE_REPEAT', 1005);
define('ERROR_REGISTER_PHONE_REPEAT_CONTENT', '注册手机号已存在，请勿重复注册');

define('ERROR_DB', 1006);

define('ERROR_PHONE_CODE', 1007);
define('ERROR_PHONE_CODE_CONTENT', '短信验证码发送异常，请稍后再试');

define('ERROR_PHONE_CODE_FREQUENTLY', 1008);
define('ERROR_PHONE_CODE_FREQUENTLY_CONTENT', '短信验证码获取过于频繁，请30分钟后重试');

define('ERROR_TOKEN_NO_EXISTS', 1009);
define('ERROR_TOKEN_NO_EXISTS_CONTENT', '令环牌字段缺失');

define('ERROR_TOKEN_CHECK_WRONG', 1010);
define('ERROR_TOKEN_CHECK_WRONG_CONTENT', '验证令环牌错误');

define('ERROR_SIGN_NO_EXISTS', 1011);
define('ERROR_SIGN_NO_EXISTS_CONTENT', '签名字段项丢失');

define('ERROR_SIGN_CHECK_WRONG', 1012);
define('ERROR_SIGN_CHECK_WRONG_CONTENT', '签名验证失败');

define('ERROR_LOGIN_NO', 1013);
define('ERROR_LOGIN_NO_CONTENT', '暂未登录');

define('ERROR_PASSWORD_FORMAT', 1014);
define('ERROR_PASSWORD_FORMAT_CONTENT', "密码格式错误");

define('ERROR_LOGIN_ING', 1015);
define('ERROR_LOGIN_ING_CONTENT', '您已登录');

define('ERROR_CHANGE_PASSWORD_SAME', 1016);
define('ERROR_CHANGE_PASSWORD_SAME_CONTENT', '新旧密码相同，请勿重复修改');

define('ERROR_SECRET_CONFIG_NO_EXISTS', 1017);
define('ERROR_SECRET_CONFIG_NO_EXISTS_CONTENT', '服务API配置异常');

define('ERROR_GPS_LOCATION', 1018);
define('ERROR_GPS_LOCATION_CONTENT', 'GPS定位异常');


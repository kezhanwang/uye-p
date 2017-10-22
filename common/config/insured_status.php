<?php
/**
 * Created by PhpStorm.
 * User: wangyi
 * Date: 2017/10/17
 * Time: 上午11:23
 */

define('INSURED_STATUS_CREATE', 100);
define('INSURED_STATUS_CREATE_CONTENT', "新建保单，平台审核中");

define('INSURED_STATUS_VERIFY_PASS', 150);
define('INSURED_STATUS_VERIFY_PASS_CONTENT', "平台通过，等待缴费");

define('INSURED_STATUS_VERIFY_REFUSE', 151);
define('INSURED_STATUS_VERIFY_REFUSE_CONTENT', "平台审核未通过");

define('INSURED_STATUS_PAYMENT', 200);
define('INSURED_STATUS_PAYMENT_CONTENT', "缴费成功，学习中");

define('INSURED_STATUS_STUDYING', 300);
define('INSURED_STATUS_STUDYING_CONTENT', "完成学习，就业中");

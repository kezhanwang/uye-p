<?php
/**
 * Created by PhpStorm.
 * User: wangyi
 * Date: 2017/10/17
 * Time: 上午11:23
 */

define('INSURED_STATUS_CREATE', 100);
define('INSURED_STATUS_CREATE_CONTENT', "审核中");
define('INSURED_STATUS_CREATE_CONTENT_ADMIN', "新建，平台审核中");
define('INSURED_STATUS_CREATE_CONTENT_ORG', "审核中");

define('INSURED_STATUS_VERIFY_PASS', 150);
define('INSURED_STATUS_VERIFY_PASS_CONTENT', "支付中");
define('INSURED_STATUS_VERIFY_PASS_CONTENT_ADMIN', "平台通过，等待缴费");
define('INSURED_STATUS_VERIFY_PASS_CONTENT_ORG', "支付中");

define('INSURED_STATUS_VERIFY_REFUSE', 151);
define('INSURED_STATUS_VERIFY_REFUSE_CONTENT', "审核拒绝");
define('INSURED_STATUS_VERIFY_REFUSE_CONTENT_ADMIN', "审核拒绝");
define('INSURED_STATUS_VERIFY_REFUSE_CONTENT_ORG', "审核拒绝");

define('INSURED_STATUS_PAY', 170);
define('INSURED_STATUS_PAY_CONTENT', '支付中');
define('INSURED_STATUS_PAY_CONTENT_ADMIN', '机构缴费，等待确认');
define('INSURED_STATUS_PAY_CONTENT_ORG', '机构缴费，等待确认');

define('INSURED_STATUS_PAYMENT', 200);
define('INSURED_STATUS_PAYMENT_CONTENT', "培训中");
define('INSURED_STATUS_PAYMENT_CONTENT_ADMIN', "缴费成功，学习中");
define('INSURED_STATUS_PAYMENT_CONTENT_ORG', "培训中");

define('INSURED_STATUS_STUDYING', 300);
define('INSURED_STATUS_STUDYING_CONTENT', "择业中");
define('INSURED_STATUS_STUDYING_CONTENT_ADMIN', "完成学习，就业中");
define('INSURED_STATUS_STUDYING_CONTENT_ORG', "择业中");

define('INSURED_STATUS_CLAIMS_WAIT', 400);
define('INSURED_STATUS_CLAIMS_WAIT_CONTENT', '等待理赔申请');
define('INSURED_STATUS_CLAIMS_WAIT_CONTENT_ADMIN', '待提交理赔');
define('INSURED_STATUS_CLAIMS_WAIT_CONTENT_ORG', '等待理赔申请');

define('INSURED_STATUS_APPLY_CLAIMS', 500);
define('INSURED_STATUS_APPLY_CLAIMS_CONTENT', '理赔受理中');
define('INSURED_STATUS_APPLY_CLAIMS_CONTENT_ADMIN', '提交理赔，审核中');
define('INSURED_STATUS_APPLY_CLAIMS_CONTENT_ORG', '理赔受理中');

define('INSURED_STATUS_CLAIMS_FORGO', 550);
define('INSURED_STATUS_CLAIMS_FORGO_CONTENT', "超过理赔期限");
define('INSURED_STATUS_CLAIMS_FORGO_CONTENT_ADMIN', "放弃理赔");
define('INSURED_STATUS_CLAIMS_FORGO_CONTENT_ORG', "放弃理赔");

define('INSURED_STATUS_CLAIMS_DOING', 600);
define('INSURED_STATUS_CLAIMS_DOING_CONTENT', '赔付中');
define('INSURED_STATUS_CLAIMS_DOING_CONTENT_ADMIN', '审核通过，赔付中');
define('INSURED_STATUS_CLAIMS_DOING_CONTENT_ORG', '赔付中');

define('INSURED_STATUS_CLAIMS_REFUSE', 650);
define('INSURED_STATUS_CLAIMS_REFUSE_CONTENT', '理赔拒绝');
define('INSURED_STATUS_CLAIMS_REFUSE_CONTENT_ADMIN', '核准拒绝');
define('INSURED_STATUS_CLAIMS_REFUSE_CONTENT_ORG', '理赔拒绝');

define('INSURED_STATUS_CLAIMS_DONE', 700);
define('INSURED_STATUS_CLAIMS_DONE_CONTENT', '已赔付');
define('INSURED_STATUS_CLAIMS_DONE_CONTENT_ADMIN', '赔付完成');
define('INSURED_STATUS_CLAIMS_DONE_CONTENT_ORG', '已赔付');

define('INSURED_STATUS_CLAIMS_END', 750);
define('INSURED_STATUS_CLAIMS_END_CONTENT', '理赔拒绝');
define('INSURED_STATUS_CLAIMS_END_CONTENT_ADMIN', '赔付终止');
define('INSURED_STATUS_CLAIMS_END_CONTENT_ORG', '理赔拒绝');

define('INSURED_STATUS_RETIRED', 800);
define('INSURED_STATUS_RETIRED_CONTENT', '订单取消');
define('INSURED_STATUS_RETIRED_CONTENT_ADMIN', '退课');
define('INSURED_STATUS_RETIRED_CONTENT_ORG', '订单取消');

define('INSURED_STATUS_SURRENDER', 810);
define('INSURED_STATUS_SURRENDER_CONTENT', '订单取消');
define('INSURED_STATUS_SURRENDER_CONTENT_ADMIN', '退保');
define('INSURED_STATUS_SURRENDER_CONTENT_ORG', '订单取消');

define('INSURED_STATUS_WORK', 820);
define('INSURED_STATUS_WORK_CONTENT', '已就业');
define('INSURED_STATUS_WORK_CONTENT_ADMIN', '就业成功');
define('INSURED_STATUS_WORK_CONTENT_ORG', '已就业');

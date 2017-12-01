<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use common\models\ar\UyeInsuredOrder;

$this->title = "保单详情";
$this->params['breadcrumbs'][] = ['label' => '保单列表', 'url' => ['list']];
$this->params['breadcrumbs'][] = $this->title;
$this->params['menu'] = $this->title;
$usi = $_SERVER['HTTP_REFERER'] ? $_SERVER['HTTP_REFERER'] : '/insured/index';
?>
<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <?= UyeInsuredOrder::$insuredType[$insured_order['insured_type']] . ":" . $insured_order['insured_order']; ?>
                <span class="tools pull-right">
                    <a href="<?php echo $usi; ?>" class="fa fa-reply"></a>
                 </span>
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-12">
                        <section class="panel">
                            <header class="panel-heading custom-tab ">
                                <ul class="nav nav-tabs">
                                    <li class="active"><a href="#insured_order" data-toggle="tab" aria-expanded="true">基本信息</a>
                                    </li>
                                    <li><a href="#mobile" data-toggle="tab" aria-expanded="true">通讯录信息</a></li>
                                    <li><a href="#study" data-toggle="tab" aria-expanded="true">学习进展</a></li>
                                    <li><a href="#work" data-toggle="tab" aria-expanded="true">就业进展</a></li>
                                    <li><a href="#repay" data-toggle="tab" aria-expanded="true">赔付记录</a></li>
                                    <li><a href="#log" data-toggle="tab" aria-expanded="true">操作日志</a></li>
                                </ul>
                            </header>
                            <div class="panel-body">
                                <div class="tab-content">
                                    <div class="active tab-pane fade in" id="insured_order">
                                        <table class="table table-hover table-bordered table-striped">
                                            <tbody>
                                            <tr>
                                                <td colspan="4" align="center">订单信息</td>
                                            </tr>
                                            <tr>
                                                <td>保单号</td>
                                                <td colspan="3"
                                                    align="left"><?= $insured_order['insured_order']; ?></td>
                                            </tr>
                                            <tr>
                                                <td>保单类型</td>
                                                <td><?= UyeInsuredOrder::$insuredType[$insured_order['insured_type']]; ?></td>
                                                <td>保单状态</td>
                                                <td><?= UyeInsuredOrder::getInsuredStatusDesp($insured_order['insured_status']); ?></td>
                                            </tr>
                                            </tbody>
                                        </table>
                                        <table class="table table-hover table-bordered table-striped">
                                            <tbody>
                                            <tr>
                                                <td colspan="4" align="center">身份信息</td>
                                            </tr>
                                            <tr>
                                                <td>姓名：</td>
                                                <td><?= $insured_order['full_name'] . '(' . $insured_order['uid'] . ')' ?></td>
                                                <td>身份证号</td>
                                                <td><?= $insured_order['id_card']; ?></td>
                                            </tr>
                                            <tr>
                                                <td>身份证有效期</td>
                                                <td><?= $insured_order['id_card_start'] . "~" . $insured_order['id_card_end'] ?></td>
                                                <td>手机号</td>
                                                <td><?= $insured_order['auth_mobile']; ?></td>
                                            </tr>
                                            <tr>
                                                <td>银行卡号</td>
                                                <td><?= $insured_order['bank_card_number'] ?></td>
                                                <td>开户行</td>
                                                <td><?= $insured_order['open_bank'] . '(' . $insured_order['open_bank_code'] . ')' ?></td>
                                            </tr>
                                            </tbody>
                                        </table>
                                        <table class="table table-hover table-bordered table-striped">
                                            <tbody>
                                            <tr>
                                                <td colspan="4" align="center">个人经历</td>
                                            </tr>
                                            <tr>
                                                <td>最高学历</td>
                                                <td><?= $expre['highest_education']; ?></td>
                                                <td>职业</td>
                                                <td><?= $expre['profession']; ?></td>
                                            </tr>
                                            <tr>
                                                <td>月收入</td>
                                                <td><?= number_format(($expre['monthly_income'] / 100), 2); ?></td>
                                                <td>住房情况</td>
                                                <td><?= $expre['housing_situation']; ?></td>
                                            </tr>
                                            <tr>
                                                <td>期望工作地点</td>
                                                <td colspan="4" align="left">
                                                    <?php if (!empty($expre['will_work_city'])) {
                                                        $work_city = json_decode($expre['will_work_city']);
                                                        if (!is_array($work_city)) {
                                                            echo "";
                                                        } else {
                                                            echo implode(',', $work_city);
                                                        }
                                                    } ?>
                                                </td>
                                            </tr>

                                            </tbody>
                                        </table>
                                        <table class="table table-hover table-bordered table-striped">
                                            <thead>
                                            <tr>
                                                <td colspan="4" align="center">职业信息</td>
                                            </tr>
                                            <tr>
                                                <td>时间</td>
                                                <td>单位名称</td>
                                                <td>职位</td>
                                                <td>薪资</td>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <?php if (!empty($workExpre)) { ?>
                                                <?php foreach ($workExpre as $item) { ?>
                                                    <tr>
                                                        <td><?= $item['date_start'] . '~' . $item['date_end']; ?></td>
                                                        <td><?= $item['work_name']; ?></td>
                                                        <td><?= $item['work_position']; ?></td>
                                                        <td><?= number_format(($item['work_salary'] / 100), 2); ?></td>
                                                    </tr>
                                                <?php } ?>
                                            <?php } else { ?>
                                                <tr>
                                                    <td colspan="4" align="center">暂无职业信息</td>
                                                </tr>
                                            <?php } ?>
                                            </tbody>
                                        </table>
                                        <table class="table table-hover table-bordered table-striped">
                                            <thead>
                                            <tr>
                                                <td colspan="5" align="center">学历信息</td>
                                            </tr>
                                            <tr>
                                                <td>时间</td>
                                                <td>学历</td>
                                                <td>学校</td>
                                                <td>专业</td>
                                                <td>地址</td>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <?php if (!empty($studyExpre)) { ?>
                                                <?php foreach ($studyExpre as $item) { ?>
                                                    <tr>
                                                        <td><?= $item['date_start'] . '~' . $item['date_end']; ?></td>
                                                        <td><?= $item['education']; ?></td>
                                                        <td><?= $item['school_name']; ?></td>
                                                        <td><?= $item['school_profession']; ?></td>
                                                        <td><?= $item['school_address'] ?></td>
                                                    </tr>
                                                <?php } ?>
                                            <?php } else { ?>
                                                <tr>
                                                    <td colspan="5" align="center">暂无学历信息</td>
                                                </tr>
                                            <?php } ?>
                                            </tbody>
                                        </table>
                                        <table class="table table-hover table-bordered table-striped">
                                            <tbody>
                                            <tr>
                                                <td colspan="4" align="center">联系信息</td>
                                            </tr>
                                            <tr>
                                                <td>家庭住址</td>
                                                <td colspan="3"><?= $contact['address'] . $contact['home_address']; ?></td>
                                            </tr>
                                            <tr>
                                                <td>微信号</td>
                                                <td><?= $contact['wechat']; ?></td>
                                                <td>QQ号</td>
                                                <td><?= $contact['qq']; ?></td>
                                            </tr>
                                            <tr>
                                                <td>电子邮箱</td>
                                                <td><?= $contact['email']; ?></td>
                                                <td>婚姻状态</td>
                                                <td><?= $contact['marriage']; ?></td>
                                            </tr>
                                            <tr>
                                                <td>紧急联系人姓名</td>
                                                <td><?= $contact['contact1_name']; ?></td>
                                                <td>紧急联系人关系</td>
                                                <td><?= $contact['contact1_phone']; ?></td>
                                            </tr>
                                            <tr>
                                                <td>紧急联系人电话</td>
                                                <td><?= $contact['contact1_relation']; ?></td>
                                                <td></td>
                                                <td></td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="tab-pane fade" id="mobile">
                                        <table class="table table-hover table-bordered table-striped">
                                            <thead>
                                            <tr>
                                                <td colspan="4" align="center">通讯录</td>
                                            </tr>
                                            <tr>
                                                <td>姓名</td>
                                                <td>手机号1</td>
                                                <td>手机号2</td>
                                                <td>手机号3</td>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <?php foreach ($mobile as $item) { ?>
                                                <tr>
                                                    <td><?= $item['firstname'] . $item['lastname']; ?></td>
                                                    <td><?= $item['mobile1']; ?></td>
                                                    <td><?= $item['mobile2']; ?></td>
                                                    <td><?= $item['mobile3']; ?></td>
                                                </tr>
                                            <?php } ?>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="tab-pane fade" id="study">
                                        <table class="table table-hover table-bordered table-striped">
                                            <thead>
                                            <tr>
                                                <td colspan="4" align="center">学习进展记录</td>
                                            </tr>
                                            </thead>
                                        </table>
                                    </div>
                                    <div class="tab-pane fade" id="work">
                                        <table class="table table-hover table-bordered table-striped">
                                            <thead>
                                            <tr>
                                                <td colspan="4" align="center">就业进展记录</td>
                                            </tr>
                                            </thead>
                                        </table>
                                    </div>
                                    <div class="tab-pane fade" id="repay">
                                        <table class="table table-hover table-bordered table-striped">
                                            <thead>
                                            <tr>
                                                <td colspan="4" align="center">赔付记录</td>
                                            </tr>
                                            </thead>
                                        </table>
                                    </div>
                                    <div class="tab-pane fade" id="log">
                                        <table class="table table-hover table-bordered table-striped">
                                            <thead>
                                            <tr>
                                                <td>序号</td>
                                                <td>保单号</td>
                                                <td>状态变更</td>
                                                <td>记录时间</td>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <?php foreach ($log as $item) { ?>
                                                <tr>
                                                    <td><?= $item['id']; ?></td>
                                                    <td><?= $item['insured_order']; ?></td>
                                                    <td><?php
                                                        if ($item['status_after'] > INSURED_STATUS_CREATE) {
                                                            echo UyeInsuredOrder::getInsuredStatusDesp($item['status_before']) . "=>" . UyeInsuredOrder::getInsuredStatusDesp($item['status_after']);
                                                        } else {
                                                            echo UyeInsuredOrder::getInsuredStatusDesp($item['status_after']);
                                                        }
                                                        ?></td>
                                                    <td><?= date('Y-m-d H:i:s', $item['created_time']); ?></td>
                                                </tr>
                                            <?php } ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </section>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

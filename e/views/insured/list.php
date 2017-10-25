<?php

use yii\helpers\Html;
use yii\widgets\Pjax;

$insuredStatus = \common\models\ar\UyeInsuredOrder::getInsuredStatusDesp();
$this->title = '审批列表';
$this->params['breadcrumbs'][] = $this->title;
$this->params['menu'] = $this->title;
\e\assets\AppAsset::addCss($this, "/js/bootstrap-datepicker/css/datepicker-custom.css");
\e\assets\AppAsset::addJs($this, "/js/bootstrap-datepicker/js/bootstrap-datepicker.js");
?>
<div class="row">
    <div class="col-sm-12">
        <div class="panel panel-default">
            <div class="panel-heading">检索条件</div>
            <form class="form_inline" name="form1">
                <input type="hidden" name="excel" value="0"/>
                <div class="panel-body">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>个人信息</label>
                            <input type="text" name="key" class="form-control" placeholder="订单号/姓名/手机号/身份证号"
                                   value="<?= Yii::$app->request->get('key'); ?>">
                        </div>
                        <div class="form-group">
                            <label>分校</label>
                            <select class="form-control" name="org">
                                <option value="">请选择状态</option>
                                <?php foreach ($insuredStatus as $key => $val) { ?>
                                    <option value="<?= $key ?>" <?php if (Yii::$app->request->get('org' == $key)) {
                                        echo "selected";
                                    } ?>><?= $val; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>订单状态</label>
                            <select class="form-control" name="insured_status">
                                <option value="">请选择状态</option>
                                <?php foreach ($insuredStatus as $key => $val) { ?>
                                    <option value="<?= $key ?>" <?php if (Yii::$app->request->get('insured_status' == $key)) {
                                        echo "selected";
                                    } ?>><?= $val; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>申请时间</label>
                            <div class="input-group">
                                <input type="text" class="form-control selectDate" placeholder="起始时间" name="beginDate"
                                       value="<?= Yii::$app->request->get('beginDate'); ?>">
                                <div class="input-group-addon">~</div>
                                <input type="text" class="form-control selectDate" name="endDate" placeholder="结束时间"
                                       value="<?= Yii::$app->request->get('endDate'); ?>">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>支付时间</label>
                            <div class="input-group">
                                <input type="text" class="form-control selectDate" placeholder="开始时间"
                                       name="paybeginDate" value="<?= Yii::$app->request->get('paybeginDate'); ?>">
                                <div class="input-group-addon">~</div>
                                <input type="text" class="form-control selectDate" name="payendDate"
                                       placeholder="结束时间" value="<?= Yii::$app->request->get('payendDate'); ?>">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="panel-footer">
                    <?= Html::submitButton('查询', ['class' => 'btn btn-primary btn-sm']) ?>
                    <?= Html::resetButton('重置', ['class' => 'btn btn-default btn-sm']) ?>
                    <input type="button" class="btn btn-default btn-sm"
                           onclick="document.getElementsByName('excel')[0].value=1;document.form1.submit();"
                           value="导出"/>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-sm-12">
        <div class="panel panel-default">
            <div class="panel-heading">保单列表</div>
            <div class="panel-body" style="overflow-x: auto;">
                <?php Pjax::begin(); ?>
                <table class="table  table-hover general-table">
                    <thead>
                    <tr>
                        <td>单号</td>
                        <td>状态</td>
                        <td>姓名</td>
                        <td>分校</td>
                        <td>申请时间</td>
                        <td>支付时间</td>
                        <td>学费</td>
                        <td>服务费</td>
                        <td>操作</td>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($data as $datum) { ?>
                        <tr>
                            <td><?= $datum['insured_order']; ?></td>
                            <td><?= \common\models\ar\UyeInsuredOrder::getInsuredStatusDesp($datum['insured_status']); ?></td>
                            <td><?= $datum['full_name'] . "<br>" . $datum['id_card'] . "<br>" . $datum['auth_mobile']; ?></td>
                            <td><?= $datum['org_name'] . "<br>" . $datum['c_name'] . "<br>" . $datum['course_consultant']; ?></td>
                            <td><?= date('Y-m-d H:i:s', $datum['created_time']); ?></td>
                            <td><?php
                                if ($datum['insured_status'] > INSURED_STATUS_VERIFY_REFUSE) {
                                    echo date('Y-m-d H:i:s', $datum['created_time']);
                                } else {
                                    echo "暂未支付";
                                }
                                ?>
                            </td>
                            <td><?= "￥" . number_format(($datum['tuition'] / 100), 2) ?></td>
                            <td><?= "￥" . number_format(($datum['premium_amount'] / 100), 2) ?></td>
                            <td>
                                <?php if ($datum['insured_status'] == INSURED_STATUS_VERIFY_PASS) { ?>
                                    <button class="btn btn-success btn-sm"
                                            onclick="pay(<?= $datum['id']; ?>,<?= $datum['insured_order'] ?>,<?= $datum['premium_amount'] ?>);">
                                        支付
                                    </button>
                                    <button class="btn btn-danger btn-sm" onclick="refuse_pay(<?= $datum['id']; ?>);">
                                        拒绝
                                    </button>
                                <?php } ?>
                                <a href="<?= \yii\helpers\Url::toRoute(['/insured/view', 'id' => $datum['id']]) ?>"
                                   class="btn btn-info btn-sm">查看</a>
                            </td>
                        </tr>
                    <?php } ?>
                    </tbody>
                </table>
                <?= \yii\widgets\LinkPager::widget(['pagination' => $pages, 'firstPageLabel' => '首页', 'lastPageLabel' => '尾页',]); ?>
                <?php Pjax::end(); ?>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title">提示窗</h4>
            </div>
            <div class="modal-body row">
                <div class="col-md-12">
                    <h4 align="center">您确定取消投保？</h4>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-danger btn-sm" id="refuse_pay" type="button">拒绝投保</button>
                <button class="btn btn-info btn-sm" type="button" data-dismiss="modal" aria-hidden="true">取消操作</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="myModal2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title">提示窗</h4>
            </div>
            <div class="modal-body row">
                <div class="col-md-12">
                    <h4 align="center" id="pay_msg"></h4>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-danger btn-sm" id="pay" type="button">继续支付</button>
                <button class="btn btn-info btn-sm" type="button" data-dismiss="modal" aria-hidden="true">取消操作</button>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    window.__async.push(
        function () {
            $('.selectDate').datepicker({
                format: 'yyyy-mm-dd',
                autoclose: true
            });
        }
    );

    function refuse_pay(id) {
        $('#myModal').modal('show');
        var csrfToken = $('meta[name="csrf-token"]').attr("content");
        $('#refuse_pay').click(function () {
            $.ajax({
                type: "GET",
                url: '/insured/refusepay',
                data: {'id': id, '_csrf': csrfToken},
                dataType: "json",
                success: function (responseData) {
                    if (responseData.code == 1000) {
                        $('#myModal').modal('hide');
                        alert("操作成功", "提示", function () {
                            history.go(0);
                        });
                    } else {
                        $('#myModal').modal('hide');
                        alert(responseData.msg, "提示", function () {
                            history.go(0);
                        });
                    }
                }
            });
        })
    }

    function pay(id, order, money) {
        $('#pay_msg').html("正在支付订单" + order + ",服务费金额" + money / 100 + "元");
        $('#myModal2').modal('show');
        var csrfToken = $('meta[name="csrf-token"]').attr("content");
        $('#pay').click(function () {
            showLoading("处理中，请稍候");
            $('#pay_msg').html("");
            $('#myModal2').modal('hide');
            $.ajax({
                type: "GET",
                url: '/insured/pay',
                data: {'id': id, '_csrf': csrfToken},
                dataType: "json",
                success: function (responseData) {
                    hideLoading();
                    if (responseData.code == 1000) {
                        alert("操作成功", "提示", function () {
                            history.go(0);
                        });
                    } else {
                        alert(responseData.msg, "提示", function () {
                            history.go(0);
                        });
                    }
                }
            });
        })
    }
</script>
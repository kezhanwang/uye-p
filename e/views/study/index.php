<?php

use yii\helpers\Html;
use yii\widgets\Pjax;
use \common\models\ar\UyeInsuredOrder;

$insuredStatus = UyeInsuredOrder::getInsuredStatusDesp('', UyeInsuredOrder::CLIENT_ORG);
$this->title = '学习进展-审批列表';
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
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>订单状态</label>
                                <select class="form-control" name="insured_status" readonly>
                                    <option value="<?php echo INSURED_STATUS_STUDYING ?>"
                                            selected><?= INSURED_STATUS_STUDYING_CONTENT_ORG; ?></option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>申请时间</label>
                                <div class="input-group">
                                    <input type="text" class="form-control selectDate" placeholder="起始时间"
                                           name="beginDate"
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
                                <td><?= UyeInsuredOrder::getInsuredStatusDesp($datum['insured_status'], UyeInsuredOrder::CLIENT_ORG); ?></td>
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
                                    <a class="btn btn-info btn-sm" onclick="graduation(<?= $datum['id']; ?>)">已毕业</a>
                                    <a class="btn btn-info btn-sm" href="<?= \yii\helpers\Url::to(['/study/add','id'=>$datum['id']])?>">学习进展</a>
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
                        <h4 align="center">确定该用户已完成学业？</h4>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-danger btn-sm" id="sure_graduation" type="button">已毕业</button>
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

        function graduation(insured_id) {
            $('#myModal').modal('show');
            var csrfToken = $('meta[name="csrf-token"]').attr("content");
            $('#sure_graduation').click(function () {
                $.ajax({
                    type: "GET",
                    url: '/study/graduation',
                    data: {'id': insured_id, '_csrf': csrfToken},
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

        <?php $this->beginBlock('study');?>
        <?php $this->endBlock();?>
    </script>
<?php $this->registerJs($this->blocks['study'], \yii\web\View::POS_END); ?>
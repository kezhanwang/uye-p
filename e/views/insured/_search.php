<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

$insuredStatus = \common\models\ar\UyeInsuredOrder::getInsuredStatusDesp();
\e\assets\AppAsset::addCss($this, '@webroot/js/bootstrap-datetimepicker/css/datetimepicker.css');
\e\assets\AppAsset::addJs($this, '@webroot/js/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js');
?>

<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading">检索条件</div>
            <?php $form = ActiveForm::begin([
                'action' => ['list'],
                'method' => 'get',
                'class' => 'form-inline',
            ]); ?>
            <div class="panel-body">
                <div class="col-md-3">
                    <div class="form-group">
                        <?= $form->field($model, 'insured_order')->textInput(['class' => 'form-control col-md-8', 'placeholder' => '订单号']) ?>
                    </div>
                    <div class="form-group">
                        <label>支付时间</label>
                        <div class="input-group date">
                            <div class="input-group-addon">
                                <i class="fa fa-calendar"></i>
                            </div>
                            <input type="text" class="form-control pull-right datepicker_search" placeholder="开始时间"
                                   name="beginDate" value="">
                            <div class="input-group-addon">TO</div>
                            <input type="text" class="form-control pull-right datepicker_search" name="endDate"
                                   placeholder="结束时间" value="">
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label>个人信息</label>
                        <input type="text" name="user_info" class="form-control col-md-8" placeholder="姓名/手机号/身份证号"
                               value="<?= $_GET['user_info'] ?>">
                    </div>
                    <div class="form-group">
                        <label>分校</label>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <?= $form->field($model, 'insured_status')->dropDownList($insuredStatus, ['class' => 'form-control col-md-8', 'placeholder' => '保单状态']) ?>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label>申请时间</label>
                        <div class="input-group date">
                            <div class="input-group-addon">
                                <i class="fa fa-calendar"></i>
                            </div>
                            <input type="text" class="form-control pull-right datepicker_search" placeholder="开始时间"
                                   name="beginDate" value="">
                            <div class="input-group-addon">TO</div>
                            <input type="text" class="form-control pull-right datepicker_search" name="endDate"
                                   placeholder="结束时间" value="">
                        </div>
                    </div>
                </div>
            </div>
            <div class="panel-footer">
                <?= Html::submitButton('查询', ['class' => 'btn btn-primary btn-sm']) ?>
                <?= Html::resetButton('重置', ['class' => 'btn btn-default btn-sm']) ?>
            </div>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function () {
        $(".datepicker_search").datetimepicker({
            format: 'YYYY-MM-DD'
        });
    });
</script>
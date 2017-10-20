<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\UyeOrgSearch */
/* @var $form yii\widgets\ActiveForm */
?>
<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading">搜索</div>
            <?php $form = ActiveForm::begin([
                'action' => ['list'],
                'method' => 'get',
                'class' => 'form-inline',
            ]); ?>
            <div class="panel-body">
                <div class="col-md-3">
                    <div class="form-group">
                        <?= $form->field($model, 'insured_order')->textInput(['class' => 'form-control col-md-8', 'placeholder' => '保单号']) ?>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <?= $form->field($model, 'insured_status')->textInput(['class' => 'form-control col-md-8', 'placeholder' => '保单状态']) ?>
                    </div>
                </div>
                <div class="col-md-3">
                    <?= $form->field($model, 'insured_type')->textInput(['class' => 'form-control col-md-8', 'placeholder' => '保单类型']) ?>
                </div>
                <div class="col-md-3">
                    <?= $form->field($model, 'uid')->textInput(['class' => 'form-control col-md-8', 'placeholder' => '申请用户']) ?>
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
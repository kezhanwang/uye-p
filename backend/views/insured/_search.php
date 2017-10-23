<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\UyeOrgSearch */
/* @var $form yii\widgets\ActiveForm */
$status = \common\models\ar\UyeInsuredOrder::getInsuredStatusDesp();
?>

<div class="box box-default">
    <div class="box-header with-border">
        <h3 class="box-title">搜索</h3>
        <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
        </div>
    </div>

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <!-- /.box-header -->
    <div class="box-body">
        <div class="row">
            <div class="col-md-3">
                <div class="form-group">
                    <?= $form->field($model, 'id')->textInput(); ?>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <?= $form->field($model, 'uid')->textInput(); ?>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <?= $form->field($model, 'insured_type')->dropDownList(\common\models\ar\UyeInsuredOrder::$insuredType, ['prompt' => '请选择']); ?>
                </div>

            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <?= $form->field($model, 'insured_status')->dropDownList($status, ['prompt' => '请选择']); ?>
                </div>
            </div>
        </div>
    </div>
    <div class="box-footer">
        <?= Html::submitButton('查询', ['class' => 'btn btn-primary btn-sm']) ?>
        <?= Html::resetButton('重置', ['class' => 'btn btn-default btn-sm']) ?>
        <?= Html::a('新加机构', ['create'], ['class' => 'btn btn-success btn-sm']) ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>

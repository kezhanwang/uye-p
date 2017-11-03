<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\UyeOrgSearch */
/* @var $form yii\widgets\ActiveForm */
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
                <div class="form-group">
                    <?= $form->field($model, 'is_shelf')->dropDownList(\common\models\ar\UyeOrg::$isShelf, ['prompt' => '请选择']); ?>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <?= $form->field($model, 'org_name')->textInput(); ?>
                </div>
                <div class="form-group">
                    <?= $form->field($model, 'is_employment')->dropDownList(\common\models\ar\UyeOrg::$isEmployment, ['prompt' => '请选择']); ?>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <?= $form->field($model, 'org_type')->dropDownList(\common\models\ar\UyeOrg::$orgType, ['prompt' => '请选择']); ?>
                </div>
                <div class="form-group">
                    <?= $form->field($model, 'is_high_salary')->dropDownList(\common\models\ar\UyeOrg::$isHighSalary, ['prompt' => '请选择']); ?>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <?= $form->field($model, 'status')->dropDownList(\common\models\ar\UyeOrg::$orgStatus, ['prompt' => '请选择']); ?>
                </div>
            </div>
        </div>
    </div>
    <div class="box-footer">
        <?= Html::submitButton('查询', ['class' => 'btn btn-primary btn-sm']) ?>
        <?= Html::resetButton('重置', ['class' => 'btn btn-default btn-sm']) ?>
        <?= Html::a('新加总校', ['create'], ['class' => 'btn btn-success btn-sm']) ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>

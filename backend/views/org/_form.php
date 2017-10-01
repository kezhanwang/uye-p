<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\UyeOrg */
/* @var $form yii\widgets\ActiveForm */
?>
<div class="box box-default">
    <div class="box-header with-border">
        <h3 class="box-title">机构信息</h3>
    </div>
    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>
    <div class="box-body">
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <?= $form->field($model, 'org_name')->textInput(['maxlength' => true]) ?>
                </div>
                <div class="form-group">
                    <?= $form->field($model, 'org_type')->dropDownList(\common\models\ar\UyeOrg::$orgType, ['prompt' => '请选择']) ?>
                </div>
                <div class="form-group">
                    <?= $form->field($model, 'is_high_salary')->dropDownList(\common\models\ar\UyeOrg::$isHighSalary, ['prompt' => '请选择']) ?>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <?= $form->field($model, 'org_short_name')->textInput(['maxlength' => true]) ?>
                </div>
                <div class="form-group">
                    <?= $form->field($model, 'is_employment')->dropDownList(\common\models\ar\UyeOrg::$isEmployment, ['prompt' => '请选择']) ?>
                </div>
                <div class="form-group">
                    <?= $form->field($infoModel, 'phone')->textInput(['maxlength' => true]) ?>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <?= $form->field($model, 'imageFile')->fileInput() ?>
            </div>
        </div>
    </div>
    <!-- /.box-body -->
    <div class="box-footer">
        <?= Html::submitButton('提交', ['class' => 'btn btn-primary btn-sm']) ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>

<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\UyeAppVersion */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="box box-default">
    <div class="box-header with-border">
        <h3 class="box-title">机构信息</h3>
    </div>

    <?php $form = ActiveForm::begin(); ?>
    <div class="box-body">
        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    <?= $form->field($model, 'type')->textInput() ?>
                </div>
                <div class="form-group">
                    <?= $form->field($model, 'version_code')->textInput() ?>
                </div>
                <div class="form-group">
                    <?= $form->field($model, 'version_name')->textInput(['maxlength' => true]) ?>
                </div>
                <div class="form-group">
                    <?= $form->field($model, 'desp')->textarea(['rows' => 6]) ?>
                </div>
                <div class="form-group">
                    <?= $form->field($model, 'url')->textInput(['maxlength' => true]) ?>
                </div>
                <div class="form-group">
                    <?= $form->field($model, 'size')->textInput() ?>
                </div>
                <div class="form-group">
                    <?= $form->field($model, 'force_update')->textInput() ?>
                </div>
                <div class="form-group">
                    <?= $form->field($model, 'status')->textInput() ?>
                </div>
                <div class="form-group">
                    <?= $form->field($model, 'created_time')->textInput() ?>
                </div>
            </div>
        </div>
    </div>
    <div class="box-footer">
        <?= Html::submitButton($model->isNewRecord ? '创建' : '更新', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
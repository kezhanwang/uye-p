<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\UyeAppVersionSearch */
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
        'action' => ['version'],
        'method' => 'get',
    ]); ?>
    <div class="box-body">
        <div class="row">
            <div class="col-md-3">
                <div class="form-group">
                    <?= $form->field($model, 'id') ?>
                </div>
                <div class="form-group">
                    <?= $form->field($model, 'desp') ?>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <?= $form->field($model, 'type') ?>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <?= $form->field($model, 'version_code') ?>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <?= $form->field($model, 'version_name') ?>
                </div>
            </div>
        </div>
    </div>
    <div class="box-footer">
        <?= Html::submitButton('查询', ['class' => 'btn btn-primary btn-sm']) ?>
        <?= Html::resetButton('重置', ['class' => 'btn btn-default btn-sm']) ?>
        <?= Html::a('新增版本', ['vcreate'], ['class' => 'btn btn-success btn-sm']) ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>

<?php // echo $form->field($model, 'url') ?>

<?php // echo $form->field($model, 'size') ?>

<?php // echo $form->field($model, 'force_update') ?>

<?php // echo $form->field($model, 'status') ?>

<?php // echo $form->field($model, 'created_time') ?>


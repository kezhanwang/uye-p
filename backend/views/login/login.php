<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */

/* @var $model \common\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = '登录-' . Yii::$app->name;
$this->params['breadcrumbs'][] = $this->title;
$fieldOptions1 = [
    'options' => ['class' => 'form-group has-feedback'],
    'inputTemplate' => "{input}<span class='glyphicon glyphicon-envelope form-control-feedback'></span>"
];

$fieldOptions2 = [
    'options' => ['class' => 'form-group has-feedback'],
    'inputTemplate' => "{input}<span class='glyphicon glyphicon-lock form-control-feedback'></span>"
];
?>
<div class="login-box">
    <div class="login-logo">
        <a href="javascript:void (0)"><b><?= Yii::$app->name; ?></b>管理平台</a>
    </div>
    <!-- /.login-logo -->
    <div class="login-box-body">
        <?php $form = ActiveForm::begin(['id' => 'login-form']); ?>
        <p class="login-box-msg">请输入手机号和密码</p>
        <div class="form-group has-feedback">
            <?= $form->field($model, 'username', $fieldOptions1)->label(false)->textInput(['autofocus' => true]) ?>
        </div>
        <div class="form-group has-feedback">
            <?= $form->field($model, 'password', $fieldOptions2)->label(false)->passwordInput() ?>
        </div>
        <div class="row">
            <div class="col-xs-8">
                <?= $form->field($model, 'rememberMe')->checkbox() ?>
            </div>
            <div class="col-xs-4">
                <?= Html::submitButton('登录', ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
            </div>
        </div>
        <?php ActiveForm::end(); ?>
    </div>

</div>
<div class="row" align="center">
    <p> &copy; <?= date('Y'); ?>
        Bjzhongteng.com <?= Yii::$app->params['company_name']; ?> <?= Yii::$app->params['case_number']; ?>
</div>
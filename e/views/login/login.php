<?php
$this->title = "机构管理员登录-" . Yii::$app->name;

use yii\helpers\Html;
use yii\widgets\ActiveForm;

?>
<div class="container">
    <?php $form = ActiveForm::begin(['id' => 'login-form', 'action' => ['/login/login'], 'method' => 'post', 'options' => ['class' => 'form-signin']]); ?>
    <!--    <form class="form-signin" action="" method="post">-->
    <div class="form-signin-heading text-center">
        <h1 class="sign-title">登录</h1>
        <img src="/images/logo-login.png" alt=""/>
    </div>
    <div class="login-wrap">
        <?= $form->field($model, 'username')->textInput(['autofocus' => true, 'class' => 'form-control', 'maxlength' => 11, 'placeholder' => '用户名']) ?>
        <?= $form->field($model, 'password')->passwordInput(['class' => 'form-control', 'maxlength' => 20, 'placeholder' => '密码']) ?>

        <button class="btn btn-lg btn-login btn-block" type="submit">
            <i class="fa fa-check"></i>
        </button>
    </div>
    <!--    </form>-->
    <?php ActiveForm::end(); ?>
</div>
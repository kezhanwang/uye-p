<?php
$this->title = "机构管理员登录-" . Yii::$app->name;

use yii\helpers\Html;
use yii\widgets\ActiveForm;

?>
<div class="container">
    <?php $form = ActiveForm::begin(['action' => ['/e/login/login'], 'method' => 'post', 'options' => ['class' => 'form-signin']]); ?>
    <!--    <form class="form-signin" action="" method="post">-->
    <div class="form-signin-heading text-center">
        <h1 class="sign-title">登录</h1>
        <img src="/e/images/logo-login.png" alt=""/>
    </div>
    <div class="login-wrap">
        <input type="text" name="phone" class="form-control" placeholder="用户名" autofocus maxlength="11">
        <input type="password" name="password" class="form-control" placeholder="密码" maxlength="20">

        <button class="btn btn-lg btn-login btn-block" type="submit">
            <i class="fa fa-check"></i>
        </button>
    </div>
    <!--    </form>-->
    <?php ActiveForm::end(); ?>
</div>
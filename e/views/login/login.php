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
        <div class="form-group field-loginform-username required">
            <label class="control-label" for="loginform-username">用户名</label>
            <input type="text" id="loginform-username" class="form-control" name="LoginForm[username]" maxlength="11"
                   autofocus="" placeholder="用户名" aria-required="true">
            <div class="help-block"></div>
        </div>
        <div class="form-group field-loginform-password required">
            <label class="control-label" for="loginform-password">密码</label>
            <input type="password" id="loginform-password" class="form-control" name="LoginForm[password]"
                   maxlength="20" placeholder="密码" aria-required="true">
            <div class="help-block"></div>
        </div>

        <button class="btn btn-lg btn-login btn-block" type="submit">
            <i class="fa fa-check"></i>
        </button>
    </div>
    <!--    </form>-->
    <?php ActiveForm::end(); ?>
</div>
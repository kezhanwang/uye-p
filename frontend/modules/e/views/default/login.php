<?php
$this->title = "机构管理员登录-" . Yii::$app->name;
?>
<div class="container">

    <form class="form-signin" action="index.html">
        <div class="form-signin-heading text-center">
            <h1 class="sign-title">登录</h1>
            <img src="/e/images/login-logo.png" alt=""/>
        </div>
        <div class="login-wrap">
            <input type="text" class="form-control" placeholder="用户名" autofocus>
            <input type="password" class="form-control" placeholder="密码">

            <button class="btn btn-lg btn-login btn-block" type="submit">
                <i class="fa fa-check"></i>
            </button>
        </div>
    </form>
</div>
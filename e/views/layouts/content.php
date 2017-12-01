<?php

use yii\widgets\Breadcrumbs;
use dmstr\widgets\Alert;

?>
<!-- page heading start-->
<div class="page-heading">
    <h3>
        <?= $this->params['menu'] ?>
    </h3>
    <ul class="breadcrumb">
        <li>
            <a href="<?= \yii\helpers\Url::toRoute(['/site/index']) ?>">首页</a>
        </li>
        <li class="active"><?= $this->params['menu'] ?></li>
    </ul>
</div>
<!-- page heading end-->
<!--body wrapper start-->
<div class="wrapper">
    <?= Alert::widget() ?>
    <?= $content ?>
</div>

<footer class="main-footer" style="position: fixed;bottom: 0;">
    <strong>Copyright &copy; <?= date('Y') ?> <?= Yii::$app->params['company_name']; ?></strong>
</footer>
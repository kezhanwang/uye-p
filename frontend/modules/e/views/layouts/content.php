<?php

use yii\widgets\Breadcrumbs;
use dmstr\widgets\Alert;

?>
<!-- page heading start-->
<div class="page-heading">
    <h3>
        <?= $this->params['menu'] ?>
    </h3>
</div>
<!-- page heading end-->
<!--body wrapper start-->
<div class="wrapper">
    <?= Alert::widget() ?>
    <?= $content ?>
</div>

<footer class="main-footer">
    <strong>Copyright &copy; <?= date('Y') ?> <?= Yii::$app->params['company_name']; ?></strong>
</footer>
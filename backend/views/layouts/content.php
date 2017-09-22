<?php

use dmstr\widgets\Alert;

$menu = \backend\models\AdminMenu::getMenuByRequestURI();
?>
<div class="content-wrapper">
    <section class="content-header">
        <h1><?= $menu['name']; ?></h1>
    </section>

    <section class="content">
        <?= Alert::widget() ?>
        <?= $content ?>
    </section>
</div>

<footer class="main-footer">
    <strong>Copyright &copy; <?= date('Y') ?> <?= Yii::$app->params['company_name']; ?></strong>
</footer>
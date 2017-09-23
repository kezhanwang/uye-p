<?php

use yii\widgets\Breadcrumbs;
use dmstr\widgets\Alert;

?>
<div class="content-wrapper">
    <section class="content-header">
        <h1>
            <?php
            if (!empty($this->params['menu'])) {
                echo \yii\helpers\Html::encode($this->params['menu']);
            } else if ($this->title !== null) {
                echo \yii\helpers\Html::encode($this->title);
            } else {
                echo \yii\helpers\Inflector::camel2words(
                    \yii\helpers\Inflector::id2camel($this->context->module->id)
                );
                echo ($this->context->module->id !== \Yii::$app->id) ? '<small>Module</small>' : '';
            } ?>
        </h1>
        <?= Breadcrumbs::widget([
            'homeLink' => ['label' => '首页', 'url' => ['/backend/']],
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
    </section>

    <section class="content">
        <?= Alert::widget() ?>
        <?= $content ?>
    </section>
</div>

<footer class="main-footer">
    <strong>Copyright &copy; <?= date('Y') ?> <?= Yii::$app->params['company_name']; ?></strong>
</footer>
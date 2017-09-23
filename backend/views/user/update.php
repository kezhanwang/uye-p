<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\UyeUser */

$this->title = 'Update Uye User: ' . $model->uid;
$this->params['breadcrumbs'][] = ['label' => 'Uye Users', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->uid, 'url' => ['view', 'id' => $model->uid]];
$this->params['breadcrumbs'][] = 'Update';
$this->params['menu'] = $this->title;
?>
<div class="uye-user-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

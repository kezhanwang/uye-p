<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\UyeAppVersion */

$this->title = 'Update Uye App Version: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Uye App Versions', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="uye-app-version-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
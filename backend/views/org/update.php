<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\UyeOrg */

$this->title = 'Update Uye Org: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Uye Orgs', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="uye-org-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

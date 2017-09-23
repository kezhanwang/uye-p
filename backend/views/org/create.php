<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\UyeOrg */

$this->title = 'Create Uye Org';
$this->params['breadcrumbs'][] = ['label' => 'Uye Orgs', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="uye-org-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

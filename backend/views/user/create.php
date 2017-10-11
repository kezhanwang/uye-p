<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\UyeUser */

$this->title = '新增用户';
$this->params['breadcrumbs'][] = ['label' => 'Uye Users', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$this->params['menu'] = $this->title;
?>
<div class="uye-user-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
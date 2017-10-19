<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\UyeAppVersion */

$this->title = '新建版本';
$this->params['breadcrumbs'][] = $this->title;
$this->params['menu'] = $this->title;
?>

<?= $this->render('_vform', [
    'model' => $model,
]) ?>

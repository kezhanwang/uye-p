<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\UyeOrg */

$this->title = '新增机构';
$this->params['breadcrumbs'][] = ['label' => '新增机构', 'url' => ['index']];
$this->params['menu'] = $this->title;
$this->params['breadcrumbs'][] = $this->title;
?>

<?= $this->render('_form', [
    'model' => $model, 'infoModel' => $infoModel
]) ?>

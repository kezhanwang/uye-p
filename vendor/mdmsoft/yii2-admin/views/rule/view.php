<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/**
 * @var yii\web\View $this
 * @var mdm\admin\models\AuthItem $model
 */
$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('rbac-admin', 'Rules'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$this->params['menu'] = $this->title;
?>
<div class="row">
    <div class="col-xs-12">
        <div class="box">
            <div class="box-header">
                <h3 class="box-title"><?= $this->title; ?></h3>
            </div>
            <div class="box-body">

                <p>
                    <?= Html::a(Yii::t('rbac-admin', 'Update'), ['update', 'id' => $model->name], ['class' => 'btn btn-primary']) ?>
                    <?php
                    echo Html::a(Yii::t('rbac-admin', 'Delete'), ['delete', 'id' => $model->name], [
                        'class' => 'btn btn-danger',
                        'data-confirm' => Yii::t('rbac-admin', 'Are you sure to delete this item?'),
                        'data-method' => 'post',
                    ]);
                    ?>
                </p>

                <?php
                echo DetailView::widget([
                    'model' => $model,
                    'attributes' => [
                        'name',
                        'className',
                    ],
                ]);
                ?>
            </div>
        </div>
    </div>
</div>

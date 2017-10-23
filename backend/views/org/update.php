<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\UyeOrg */

$this->title = '编辑: ';
$this->params['breadcrumbs'][] = ['label' => '机构列表', 'url' => ['index']];
$this->params['breadcrumbs'][] = '编辑';
$this->params['menu'] = $this->title;
?>
<div class="box box-default">
    <div class="box-header with-border">
        <h3 class="box-title">机构信息</h3>
    </div>
    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>
    <div class="box-body">
        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    <label for="exampleInputEmail1">机构名称</label>
                    <input type="text" class="form-control" value="<?= $info['org_name'] ?>" readonly>
                </div>
                <div class="form-group">
                    <label for="exampleInputEmail1">机构地址</label>
                    <input type="text" class="form-control" name="address" value="<?= $info['address']; ?>">
                </div>
                <div class="form-group">
                    <label for="exampleInputEmail1">机构电话</label>
                    <input type="text" class="form-control" name="phone" value="<?= $info['phone']; ?>">
                </div>
            </div>
        </div>
    </div>
    <!-- /.box-body -->
    <div class="box-footer">
        <?= Html::submitButton('提交', ['class' => 'btn btn-primary btn-sm']) ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>

<?php

use mdm\admin\AnimateAsset;
use yii\helpers\Html;
use yii\helpers\Json;
use yii\web\YiiAsset;

/* @var $this yii\web\View */
/* @var $routes [] */

$this->title = Yii::t('rbac-admin', 'Routes');
$this->params['breadcrumbs'][] = $this->title;
$this->params['menu'] = $this->title;
AnimateAsset::register($this);
YiiAsset::register($this);
$opts = Json::htmlEncode([
    'routes' => $routes,
]);
$this->registerJs("var _opts = {$opts};");
$this->registerJs($this->render('_script.js'));
$animateIcon = ' <i class="glyphicon glyphicon-refresh glyphicon-refresh-animate"></i>';
?>

<div class="box box-default">
    <div class="box-header with-border">
        <h3 class="box-title">新增</h3>
        <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
        </div>
    </div>
    <!-- /.box-header -->
    <div class="box-body">
        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    <div class="input-group">
                        <input id="inp-route" type="text" class="form-control"
                               placeholder="<?= Yii::t('rbac-admin', 'New route(s)'); ?>">
                        <span class="input-group-btn">
                <?= Html::a(Yii::t('rbac-admin', 'Add') . $animateIcon, ['create'], [
                    'class' => 'btn btn-success',
                    'id' => 'btn-new',
                ]); ?>
            </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-xs-12">
        <div class="box">
            <div class="box-header">
                <h3 class="box-title">数据列表</h3>
            </div>
            <div class="box-body">
                <div class="col-sm-5">
                    <div class="input-group">
                        <input class="form-control search" data-target="available"
                               placeholder="<?= Yii::t('rbac-admin', 'Search for available'); ?>">
                        <span class="input-group-btn">
                <?= Html::a('<span class="glyphicon glyphicon-refresh"></span>', ['refresh'], [
                    'class' => 'btn btn-default',
                    'id' => 'btn-refresh',
                ]); ?>
            </span>
                    </div>
                    <select multiple size="20" class="form-control list" data-target="available"></select>
                </div>

                <div class="col-sm-1">
                    <br><br>
                    <?= Html::a('&gt;&gt;' . $animateIcon, ['assign'], [
                        'class' => 'btn btn-success btn-assign',
                        'data-target' => 'available',
                        'title' => Yii::t('rbac-admin', 'Assign'),
                    ]); ?><br><br>
                    <?= Html::a('&lt;&lt;' . $animateIcon, ['remove'], [
                        'class' => 'btn btn-danger btn-assign',
                        'data-target' => 'assigned',
                        'title' => Yii::t('rbac-admin', 'Remove'),
                    ]); ?>
                </div>
                <div class="col-sm-5">
                    <input class="form-control search" data-target="assigned"
                           placeholder="<?= Yii::t('rbac-admin', 'Search for assigned'); ?>">
                    <select multiple size="20" class="form-control list" data-target="assigned"></select>
                </div>
            </div>
        </div>
    </div>
</div>


<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\UyeOrg */

$this->title = "保单详情";
$this->params['breadcrumbs'][] = ['label' => '保单详情', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$this->params['menu'] = $this->title;
\backend\assets\AppAsset::addJs($this, "http://api.map.baidu.com/api?v=2.0&ak=NKfVIRMnqsDZ1iVHfxnnYOTHYw3m3G6e")
?>
<div class="row">
    <div class="col-md-3">
        <!-- Profile Image -->
        <div class="box box-primary">
            <div class="box-body box-profile">
            </div>
        </div>
    </div>
    <div class="col-md-9">
        <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
                <li class="active"><a href="#org_info" data-toggle="tab">保单信息</a></li>
            </ul>
            <div class="tab-content">
            </div>
        </div>
    </div>
</div>

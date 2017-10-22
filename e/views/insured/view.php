<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use common\models\ar\UyeInsuredOrder;

/* @var $this yii\web\View */
/* @var $model app\models\UyeInsuredOrder */

$this->title = "保单详情";
$this->params['breadcrumbs'][] = ['label' => '保单列表', 'url' => ['list']];
$this->params['breadcrumbs'][] = $this->title;
$this->params['menu'] = $this->title;
?>
<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <?= UyeInsuredOrder::$insuredType[$model->insured_type] . ":" . $model->insured_order; ?>
                <span class="tools pull-right">
                    <a href="<?= \yii\helpers\Url::toRoute('/insured/list')?>" class="fa fa-reply"></a>
                 </span>
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="nav-tabs-custom">
                            <ul class="nav nav-tabs">
                                <li  class="active"><a href="#insured_order" data-toggle="tab" aria-expanded="true">基本信息</a></li>
                                <li><a href="#mobile" data-toggle="tab" aria-expanded="true">通讯录信息</a></li>
                                <li><a href="#study" data-toggle="tab" aria-expanded="true">学习进展</a></li>
                                <li><a href="#work" data-toggle="tab" aria-expanded="true">就业进展</a></li>
                                <li><a href="#repay" data-toggle="tab" aria-expanded="true">赔付记录</a></li>
                                <li><a href="#log" data-toggle="tab" aria-expanded="true">操作日志</a></li>
                            </ul>
                            <div class="tab-content">
                                <div class="active tab-pane" id="insured_order">
                                    <table class="table table-hover table-bordered table-striped">
                                        <tbody>
                                        <tr>
                                            <td colspan="4" align="center">订单信息</td>
                                        </tr>
                                        <tr>
                                            <td>保单号</td>
                                            <td colspan="3" align="left"><?= $model->insured_order; ?></td>
                                        </tr>
                                        <tr>
                                            <td>保单类型</td>
                                            <td><?= UyeInsuredOrder::$insuredType[$model->insured_type]; ?></td>
                                            <td>保单状态</td>
                                            <td><?= UyeInsuredOrder::getInsuredStatusDesp($model->insured_status); ?></td>
                                        </tr>
                                        </tbody>
                                    </table>
                                    <table class="table table-hover table-bordered table-striped">
                                        <tbody>
                                        <tr>
                                            <td colspan="4" align="center">身份信息</td>
                                        </tr>
                                        <tr>
                                            <td>保单号</td>
                                            <td colspan="3" align="left"><?= $model->insured_order; ?></td>
                                        </tr>
                                        <tr>
                                            <td>保单类型</td>
                                            <td><?= UyeInsuredOrder::$insuredType[$model->insured_type]; ?></td>
                                            <td>保单状态</td>
                                            <td><?= UyeInsuredOrder::getInsuredStatusDesp($model->insured_status); ?></td>
                                        </tr>
                                        </tbody>
                                    </table>
                                    <table class="table table-hover table-bordered table-striped">
                                        <tbody>
                                        <tr>
                                            <td colspan="4" align="center">个人经历</td>
                                        </tr>
                                        <tr>
                                            <td>保单号</td>
                                            <td colspan="3" align="left"><?= $model->insured_order; ?></td>
                                        </tr>
                                        <tr>
                                            <td>保单类型</td>
                                            <td><?= UyeInsuredOrder::$insuredType[$model->insured_type]; ?></td>
                                            <td>保单状态</td>
                                            <td><?= UyeInsuredOrder::getInsuredStatusDesp($model->insured_status); ?></td>
                                        </tr>
                                        </tbody>
                                    </table>
                                    <table class="table table-hover table-bordered table-striped">
                                        <tbody>
                                        <tr>
                                            <td colspan="4" align="center">职业信息</td>
                                        </tr>
                                        <tr>
                                            <td>保单号</td>
                                            <td colspan="3" align="left"><?= $model->insured_order; ?></td>
                                        </tr>
                                        <tr>
                                            <td>保单类型</td>
                                            <td><?= UyeInsuredOrder::$insuredType[$model->insured_type]; ?></td>
                                            <td>保单状态</td>
                                            <td><?= UyeInsuredOrder::getInsuredStatusDesp($model->insured_status); ?></td>
                                        </tr>
                                        </tbody>
                                    </table>
                                    <table class="table table-hover table-bordered table-striped">
                                        <tbody>
                                        <tr>
                                            <td colspan="4" align="center">学历信息</td>
                                        </tr>
                                        <tr>
                                            <td>保单号</td>
                                            <td colspan="3" align="left"><?= $model->insured_order; ?></td>
                                        </tr>
                                        <tr>
                                            <td>保单类型</td>
                                            <td><?= UyeInsuredOrder::$insuredType[$model->insured_type]; ?></td>
                                            <td>保单状态</td>
                                            <td><?= UyeInsuredOrder::getInsuredStatusDesp($model->insured_status); ?></td>
                                        </tr>
                                        </tbody>
                                    </table>
                                    <table class="table table-hover table-bordered table-striped">
                                        <tbody>
                                        <tr>
                                            <td colspan="4" align="center">联系信息</td>
                                        </tr>
                                        <tr>
                                            <td>保单号</td>
                                            <td colspan="3" align="left"><?= $model->insured_order; ?></td>
                                        </tr>
                                        <tr>
                                            <td>保单类型</td>
                                            <td><?= UyeInsuredOrder::$insuredType[$model->insured_type]; ?></td>
                                            <td>保单状态</td>
                                            <td><?= UyeInsuredOrder::getInsuredStatusDesp($model->insured_status); ?></td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="tab-pane" id="mobile">2</div>
                                <div class="tab-pane" id="study">3</div>
                                <div class="tab-pane" id="work">4</div>
                                <div class="tab-pane" id="repay">5</div>
                                <div class="tab-pane" id="log">6</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

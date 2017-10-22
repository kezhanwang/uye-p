<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel app\models\UyeOrgSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '保单列表';
$this->params['breadcrumbs'][] = $this->title;
$this->params['menu'] = $this->title;

?>
<?php echo $this->render('_search', ['model' => $searchModel]); ?>

<div class="row">
    <div class="col-sm-12">
        <div class="panel panel-default">
            <div class="panel-heading">保单列表</div>
            <div class="panel-body" style="overflow-x: auto;">
                <?php Pjax::begin(); ?>
                <?= GridView::widget([
                    'dataProvider' => $dataProvider,
                    'pager' => [
                        'firstPageLabel' => "首页",
                        'prevPageLabel' => '上一页',
                        'nextPageLabel' => '下一页',
                        'lastPageLabel' => '末页',
                    ],
                    'columns' => [
                        ['class' => 'yii\grid\SerialColumn'],//序列号从1自增长
                        'insured_order',
                        'uid',
                        [
                            'attribute' => 'insured_type',
                            'value' => function ($model) {
                                return \common\models\ar\UyeInsuredOrder::$insuredType[$model->insured_type];
                            }
                        ],

                        [
                            'attribute' => 'insured_status',
                            'value' => function ($model) {
                                return \common\models\ar\UyeInsuredOrder::getInsuredStatusDesp($model->insured_status);
                            }
                        ],
                        [
                            'label' => '申请时间',
                            'attribute' => 'created_time',
                            'format' => ['date', 'php:Y-m-d H:i:s'],
                        ],
                        [
                            'class' => 'yii\grid\ActionColumn',
                            'header' => '操作',
                            'template' => '{view} {update}',
                        ],
                    ],
                ]); ?>
                <?php Pjax::end(); ?>
            </div>
        </div>
    </div>
</div>


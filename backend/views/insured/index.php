<?php
/**
 * Created by PhpStorm.
 * User: wangyi
 * Date: 2017/10/22
 * Time: 下午5:35
 */

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;

$this->title = '保单列表';
$this->params['breadcrumbs'][] = $this->title;
$this->params['menu'] = $this->title;
?>
<?php echo $this->render('_search', ['model' => $searchModel]); ?>

<div class="row">
    <div class="col-xs-12">
        <div class="box">
            <div class="box-header">
                <h3 class="box-title">数据列表</h3>
            </div>
            <div class="box-body">
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
                        ['class' => 'yii\grid\SerialColumn'],
                        'insured_order',
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
                        'uid',

                        [
                            'header' => '操作',
                            'class' => 'yii\grid\ActionColumn',
                            'template' => '{view}',
                            'buttons' => [
                                'view' => function ($url, $model, $key) {
                                    return Html::a('查看', ['/insured/view', 'id' => $model->id], ['class' => "btn btn-sm btn-info", 'title' => '查看', 'target' => '_blank']);
                                },
                            ],
                        ],

                    ],
                ]); ?>
                <?php Pjax::end(); ?>
            </div>
        </div>
    </div>
</div>


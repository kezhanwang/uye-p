<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel app\models\UyeOrgSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '机构列表';
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
                        'id',
                        'org_name',
                        [
                            'attribute' => 'org_type',
                            'value' => function ($model) {
                                return \common\models\ar\UyeOrg::$orgType[$model->org_type];
                            }
                        ],
                        'parent_id',
                        [
                            'attribute' => 'status',
                            'value' => function ($model) {
                                return \common\models\ar\UyeOrg::$orgStatus[$model->status];
                            }
                        ],
                        [
                            'attribute' => 'is_shelf',
                            'value' => function ($model) {
                                return \common\models\ar\UyeOrg::$isShelf[$model->is_shelf];
                            }
                        ],
                        [
                            'attribute' => 'is_employment',
                            'value' => function ($model) {
                                return \common\models\ar\UyeOrg::$isEmployment[$model->is_employment];
                            }
                        ],
                        [
                            'attribute' => 'is_high_salary',
                            'value' => function ($model) {
                                return \common\models\ar\UyeOrg::$isHighSalary[$model->is_high_salary];
                            }
                        ],
                        [
                            'header' => '操作',
                            'class' => 'yii\grid\ActionColumn',
                            'template' => '{view} {update} {add} {add_org} {delete}',
                            'buttons' => [
                                'view' => function ($url, $model, $key) {
                                    return Html::a('查看', ['/org/view', 'id' => $model->id], ['class' => "btn btn-sm btn-info", 'title' => '查看', 'target' => '_blank']);
                                },
                                'update' => function ($url, $model, $key) {
                                    return Html::a('编辑', ['/org/update', 'id' => $model->id], ['class' => "btn btn-sm btn-warning", 'title' => '编辑', 'target' => '_blank']);
                                },
                                'add' => function ($url, $model, $key) {
                                    return Html::a('添加课程', ['/org/addcourse', 'id' => $model->id], ['class' => "btn btn-sm btn-success", 'title' => '添加课程', 'target' => '_blank']);
                                },
                                'delete' => function ($url, $model, $key) {
                                    if ($model->is_delete == \common\models\ar\UyeOrg::IS_DELETE_ON) {
                                        return Html::a('删除', ['/org/delete', 'id' => $model->id], ['class' => "btn btn-sm btn-danger", 'title' => '删除']);
                                    }
                                },
                                'add_org' => function ($url, $model, $key) {
                                    if ($model->org_type == \common\models\ar\UyeOrg::ORG_TYPE_GENERAL) {
                                        return Html::a('添加分校', ['/org/create', 'parent' => $model->id], ['class' => "btn btn-sm btn-info", 'title' => '添加分校', 'target' => '_blank']);
                                    }
                                }
                            ],
                        ],
                    ],
                ]); ?>
                <?php Pjax::end(); ?>
            </div>
        </div>
    </div>
</div>


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
                    'columns' => [
                        'insured_order',
                        'uid',
                        'insured_type',
                        'insured_status',
                        [
                            'label' => '申请时间',
                            'attribute' => 'created_time',
                            'format' => ['date', 'php:Y-m-d H:i:s'],
                        ],
                        // 'status',
                        // 'is_shelf',
                        // 'is_delete',
                        // 'is_employment',
                        // 'is_high_salary',
                        // 'updated_time:datetime',

                        ['label' => '操作'],
                    ],
                ]); ?>
                <?php Pjax::end(); ?>
            </div>
        </div>
    </div>
</div>


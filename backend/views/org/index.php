<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel app\models\UyeOrgSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '机构列表';
$this->params['breadcrumbs'][] = $this->title;
?>
<?php echo $this->render('_search', ['model' => $searchModel]); ?>


<div class="row">
    <div class="col-xs-12">
        <div class="box">
            <div class="box-header">
                <h3 class="box-title">数据列表</h3>
            </div>
            <div class="box-body">
                <?php Pjax::begin(); ?>    <?= GridView::widget([
                    'dataProvider' => $dataProvider,
                    'columns' => [
                        'id',
                        'org_short_name',
                        'org_name',
                        'org_type',
                        'parent_id',
                        [
                            'label' => '注册时间',
                            'attribute' => 'created_time',
                            'format' => ['date', 'php:Y-m-d H:i:s'],
                        ],
                        // 'status',
                        // 'is_shelf',
                        // 'is_delete',
                        // 'is_employment',
                        // 'is_high_salary',
                        // 'updated_time:datetime',

                        ['class' => 'yii\grid\ActionColumn'],
                    ],
                ]); ?>
                <?php Pjax::end(); ?>
            </div>
        </div>
    </div>
</div>


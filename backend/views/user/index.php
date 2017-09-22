<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel app\models\UyeUserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '用户管理';
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
                    'filterModel' => $searchModel,
                    'columns' => [
                        ['class' => 'yii\grid\SerialColumn'],
                        'uid',
                        'username',
                        'phone',
                        'email:email',
                        [
                            'label' => '状态',
                            'attribute' => 'status',
                            'value' => function ($model) {
                                return $model->status == 1 ? '可用' : '不可用';
                            }
                        ],
                        [
                            'label' => '注册时间',
                            'attribute' => 'created_time',
                            'format' => ['date', 'php:Y-m-d H:i:s'],
                        ],
                        ['class' => 'yii\grid\ActionColumn'],
                    ],
                ]); ?>
                <?php Pjax::end(); ?></div>
        </div>
    </div>
</div>

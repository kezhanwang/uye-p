<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $searchModel mdm\admin\models\searchs\Menu */

$this->title = Yii::t('rbac-admin', 'Menus');
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
                <?=
                GridView::widget([
                    'dataProvider' => $dataProvider,
                    'columns' => [
                        ['class' => 'yii\grid\SerialColumn'],
                        'name',
                        [
                            'attribute' => 'menuParent.name',
                            'filter' => Html::activeTextInput($searchModel, 'parent_name', [
                                'class' => 'form-control', 'id' => null
                            ]),
                            'label' => Yii::t('rbac-admin', 'Parent'),
                        ],
                        'route',
                        'order',
                        ['class' => 'yii\grid\ActionColumn'],
                    ],
                ]);
                ?>
                <?php Pjax::end(); ?>
            </div>
        </div>
    </div>
</div>

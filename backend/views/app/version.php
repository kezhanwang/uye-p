<?php
/**
 * Created by PhpStorm.
 * User: wangyi
 * Date: 2017/10/19
 * Time: 下午3:45
 */

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel app\models\UyeOrgSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '版本列表';
$this->params['breadcrumbs'][] = $this->title;
$this->params['menu'] = $this->title;
?>
<?php echo $this->render('_version_search', ['model' => $searchModel]); ?>

<div class="row">
    <div class="col-xs-12">
        <div class="box">
            <div class="box-header">
                <h3 class="box-title">版本控制</h3>
            </div>
            <div class="box-body">
                <?php Pjax::begin(); ?>
                <?= GridView::widget([
                    'dataProvider' => $dataProvider,
                    'columns' => [
                        'id',
                        'type',
                        'version_code',
                        'version_name',
                        'desp:ntext',
                        'status',
                        'created_time:datetime',
                        ['class' => 'yii\grid\ActionColumn'],
                    ],
                ]); ?>
                <?php Pjax::end(); ?>
            </div>
        </div>
    </div>
</div>


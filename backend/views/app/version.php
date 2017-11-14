<?php
/**
 * Created by PhpStorm.
 * User: wangyi
 * Date: 2017/10/19
 * Time: 下午3:45
 */


use yii\helpers\Html;
use yii\widgets\Pjax;
use common\models\ar\UyeAppVersion;

/* @var $this yii\web\View */
/* @var $searchModel app\models\UyeOrgSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '版本列表';
$this->params['breadcrumbs'][] = $this->title;
$this->params['menu'] = $this->title;
?>

<div class="box box-default">
    <div class="box-header with-border">
        <h3 class="box-title">工具</h3>
        <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
        </div>
    </div>
    <div class="box-footer">
        <?= Html::a('新增版本', ['vcreate'], ['class' => 'btn btn-success btn-sm']) ?>
    </div>
</div>

<div class="row">
    <div class="col-xs-12">
        <div class="box">
            <div class="box-header">
                <h3 class="box-title">版本控制</h3>
            </div>
            <div class="box-body">
                <?php Pjax::begin(); ?>
                <table class="table  table-hover general-table">
                    <thead>
                    <tr>
                        <td>ID</td>
                        <td>客户端</td>
                        <td>版本号</td>
                        <td>版本ID</td>
                        <td>状态</td>
                        <td>升级</td>
                        <td>描述</td>
                        <td>下载</td>
                        <td>创建时间</td>
                    </tr>
                    </thead>
                    <?php foreach ($lists as $list) { ?>
                        <tr>
                            <td><?= $list['id']; ?></td>
                            <td><?= UyeAppVersion::$type[$list['type']]; ?></td>
                            <td><?= $list['version_code']; ?></td>
                            <td><?= $list['version_name']; ?></td>
                            <td><?= UyeAppVersion::$status[$list['status']]; ?></td>
                            <td><?= UyeAppVersion::$forceUpdate[$list['force_update']]; ?></td>
                            <td class="col-md-3"><?= $list['desp']; ?></td>
                            <td><a href="<?= $list['url']; ?>" target="_blank"><i class="fa fa-cloud-download"></i></a>
                            </td>
                            <td><?= date('Y-m-d', $list['created_time']); ?></td>
                        </tr>
                    <?php } ?>
                    <tbody>
                    </tbody>
                </table>
                <?= \yii\widgets\LinkPager::widget(['pagination' => $pages, 'firstPageLabel' => '首页', 'lastPageLabel' => '尾页',]); ?>
                <?php Pjax::end(); ?>
            </div>
        </div>
    </div>
</div>


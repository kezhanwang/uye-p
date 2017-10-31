<?php
/**
 * Created by PhpStorm.
 * User: wangyi
 * Date: 2017/10/31
 * Time: 下午3:29
 */

use yii\helpers\Html;
use yii\widgets\Pjax;
use \common\models\ar\UyeInsuredOrder;

$this->title = '注册用户';
$this->params['breadcrumbs'][] = $this->title;
$this->params['menu'] = $this->title;
?>

<div class="box box-default">
    <div class="box-header with-border">
        <h3 class="box-title">搜索</h3>
        <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
        </div>
    </div>
    <form>
        <!-- /.box-header -->
        <div class="box-body">
            <div class="row">
                <div class="col-md-3">
                    <div class="form-group">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                    </div>
                </div>
            </div>
        </div>
        <div class="box-footer">
            <?= Html::submitButton('查询', ['class' => 'btn btn-primary btn-sm']) ?>
            <?= Html::resetButton('重置', ['class' => 'btn btn-default btn-sm']) ?>
        </div>
    </form>
</div>
<div class="row">
    <div class="col-xs-12">
        <div class="box">
            <div class="box-header">
                <h3 class="box-title">数据列表</h3>
            </div>
            <div class="box-body">
                <?php Pjax::begin(); ?>
                <table class="table  table-hover general-table">
                    <thead>
                    <tr>
                        <td>用户UID</td>
                        <td>登录账号</td>
                        <td>昵称</td>
                        <td>账户状态</td>
                        <td>注册时间</td>
                        <td>查看</td>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($users as $user) { ?>
                        <tr>
                            <td><?= $user['uid']; ?></td>
                            <td><?= $user['phone'] ?></td>
                            <td><?= $user['username'] ?></td>
                            <td><?= \common\models\ar\UyeUser::$status[$user['status']]; ?></td>
                            <td><?= date('Y-m-d H:i:s', $user['created_time']); ?></td>
                            <td>
                                <a class="btn btn-info btn-sm" href="/user/view?uid=<?= $user['uid'] ?>">查看</a>
                            </td>
                        </tr>
                    <?php } ?>
                    </tbody>
                </table>
                <?= \yii\widgets\LinkPager::widget(['pagination' => $pages, 'firstPageLabel' => '首页', 'lastPageLabel' => '尾页',]); ?>
                <?php Pjax::end(); ?>
            </div>
        </div>
    </div>
</div>
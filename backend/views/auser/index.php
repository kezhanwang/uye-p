<?php
/**
 * Created by PhpStorm.
 * User: wangyi
 * Date: 2017/10/26
 * Time: 下午3:36
 */

use yii\helpers\Html;
use yii\widgets\Pjax;

$this->title = '管理员';
$this->params['breadcrumbs'][] = $this->title;
$this->params['menu'] = $this->title;
$status = \common\models\ar\UyeAdminUser::getStatus();
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
                <div class="col-md-3"></div>
                <div class="col-md-3"></div>
                <div class="col-md-3"></div>
                <div class="col-md-3"></div>
            </div>
        </div>
        <div class="box-footer">
            <?= Html::submitButton('查询', ['class' => 'btn btn-primary btn-sm']) ?>
            <?= Html::resetButton('重置', ['class' => 'btn btn-default btn-sm']) ?>
            <?= Html::a('添加管理员', ['register'], ['class' => 'btn btn-success btn-sm']) ?>
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
                        <td>员工号</td>
                        <td>登录名</td>
                        <td>姓名</td>
                        <td>手机号</td>
                        <td>邮箱</td>
                        <td>注册时间</td>
                        <td>状态</td>
                        <td>操作</td>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($users as $user) { ?>
                        <tr>
                            <td><?= $user['id']; ?></td>
                            <td><?= $user['username']; ?></td>
                            <td><?= $user['realname']; ?></td>
                            <td><?= $user['phone']; ?></td>
                            <td><?= $user['email']; ?></td>
                            <td><?= date('Y-m-d H:i:s', $user['created_at']); ?></td>
                            <td><?= $status[$user['status']]; ?></td>
                            <td>

                                <?php if ($user['status'] == \common\models\ar\UyeAdminUser::STATUS_ACTIVE) { ?>
                                    <button class="btn btn-sm btn-danger">删除</button>
                                    <button class="btn btn-sm btn-info">重置密码</button>
                                <?php } else { ?>
                                    <button class="btn btn-sm btn-info">不可操作</button>
                                <?php } ?>
                            </td>
                        </tr>
                    <?php } ?>
                    </tbody>
                </table>
                <?php Pjax::end(); ?>
            </div>
        </div>
    </div>
</div>


<?php
/**
 * Created by PhpStorm.
 * User: wangyi
 * Date: 2017/10/26
 * Time: 下午3:36
 */

use yii\helpers\Html;
use yii\widgets\Pjax;

$this->title = '机构管理员';
$this->params['breadcrumbs'][] = $this->title;
$this->params['menu'] = $this->title;
$status = \common\models\ar\UyeEUser::getStatus();
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
                        <label>手机号</label>
                        <input class="form-control" type="text" name="phone" placeholder="手机号"
                               value="<?= Yii::$app->request->get('phone') ?>">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label>机构</label>
                        <input class="form-control" type="text" name="org" placeholder="机构id/机构名称"
                               value="<?= Yii::$app->request->get('org') ?>">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label>角色</label>
                        <select class="form-control" name="role_id">
                            <option value="0">请选择角色</option>
                            <?php foreach ($role as $item) { ?>
                                <option value="<?= $item['id']; ?>" <?php if (Yii::$app->request->get('role_id') == $item['id']) {
                                    echo 'selected';
                                } ?>><?= $item['role_name']; ?></option>
                            <?php } ?>
                        </select>
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
                        <td>员工号</td>
                        <td>登录名</td>
                        <td>机构</td>
                        <td>角色</td>
                        <td>邮箱</td>
                        <td>注册时间</td>
                        <td>状态</td>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($users as $user) { ?>
                        <tr>
                            <td><?= $user['id']; ?></td>
                            <td><?= $user['username']; ?></td>
                            <td><?= $user['org_name']; ?></td>
                            <td><?= $user['role_name']; ?></td>
                            <td><?= $user['email']; ?></td>
                            <td><?= date('Y-m-d H:i:s', $user['created_time']); ?></td>
                            <td><?= $status[$user['status']]; ?></td>
                        </tr>
                    <?php } ?>
                    </tbody>
                </table>
                <?php Pjax::end(); ?>
            </div>
        </div>
    </div>
</div>


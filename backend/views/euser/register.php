<?php
/**
 * Created by PhpStorm.
 * User: wangyi
 * Date: 2017/10/26
 * Time: 下午4:03
 */

$this->title = '添加管理员';
$this->params['breadcrumbs'][] = ['label' => '', 'url' => ''];
$this->params['breadcrumbs'][] = $this->title;
$this->params['menu'] = $this->title;
?>
<div class="row">
    <!-- left column -->
    <div class="col-md-6">
        <!-- general form elements -->
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">新增管理员</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form role="form" action="/euser/register" method="post">
                <div class="box-body">
                    <div class="form-group">
                        <label for="exampleInputPassword1">手机号</label>
                        <input type="number" name="username" class="form-control" placeholder="手机号">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword1">邮箱</label>
                        <input type="email" name="email" class="form-control" placeholder="邮箱">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword1">机构id</label>
                        <input type="number" name="org_id" class="form-control" placeholder="机构id">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword1">角色</label>
                        <select class="form-control" name="role_id">
                            <?php foreach ($role as $item) { ?>
                                <option value="<?= $item['id']; ?>"><?= $item['role_name']; ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword1">密码</label>
                        <input type="password" name="password" class="form-control" placeholder="密码">
                    </div>
                </div>
                <!-- /.box-body -->
                <div class="box-footer">
                    <button type="submit" class="btn btn-primary">注册</button>
                </div>
            </form>
        </div>
        <!-- /.box -->
    </div>
</div>

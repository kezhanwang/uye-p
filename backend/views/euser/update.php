<?php
/**
 * Created by PhpStorm.
 * User: wangyi
 * Date: 2017/12/1
 * Time: 上午11:08
 */

use yii\widgets\ActiveForm;

$this->title = '修改信息';
$this->params['breadcrumbs'][] = ['label' => '机构管理员', 'url' => ['/euser/index']];
$this->params['breadcrumbs'][] = $this->title;
$this->params['menu'] = $this->title;
?>
<div class="row">
    <div class="col-md-6">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">修改信息</h3>
            </div>
            <?php $form = ActiveForm::begin([
                'action' => ['/euser/update'],
                'method' => 'post',
            ]); ?>
            <div class="box-body">
                <input type="hidden" name="id" value="<?php echo $user['id']; ?>">
                <input type="hidden" name="type" value="update">
                <div class="form-group">
                    <label for="exampleInputPassword1">机构</label>
                    <input type="text" class="form-control" value="<?php echo $org['org_name']; ?>"
                           readonly>
                </div>
                <div class="form-group">
                    <label for="exampleInputPassword1">手机号</label>
                    <input type="number" class="form-control" value="<?php echo $user['username']; ?>"
                           readonly>
                </div>
                <div class="form-group">
                    <label for="exampleInputPassword1">邮箱</label>
                    <input type="email" name="email" class="form-control" value="<?php echo $user['email']; ?>">
                </div>
                <div class="form-group">
                    <label for="exampleInputPassword1">角色</label>
                    <select class="form-control" name="role_id">
                        <?php foreach ($role as $item) { ?>
                            <option value="<?= $item['id']; ?>" <?php if ($rbac['role_id'] == $item['id']) {
                                echo "selected";
                            } ?>><?= $item['role_name']; ?></option>
                        <?php } ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="exampleInputPassword1">密码</label>
                    <input type="password" name="password" class="form-control" placeholder="密码">
                </div>
            </div>
            <div class="box-footer">
                <button type="submit" class="btn btn-primary">更新</button>
            </div>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>

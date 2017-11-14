<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\models\ar\UyeAppVersion;

$this->title = '添加APP版本';
$this->params['breadcrumbs'][] = ['label' => '版本控制', 'url' => ['version']];
$this->params['breadcrumbs'][] = $this->title;
$this->params['menu'] = $this->title;

$type = UyeAppVersion::$type;
?>

<div class="box box-default">
    <div class="box-header with-border">
        <h3 class="box-title">版本信息</h3>
    </div>

    <?php $form = ActiveForm::begin(['options' => []]); ?>
    <div class="box-body">
        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    <?= $form->field($model, 'type')->dropDownList($type, ['prompt' => '请选择']) ?>
                </div>
                <div class="form-group">
                    <?= $form->field($model, 'version_code')->textInput() ?>
                </div>
                <div class="form-group">
                    <?= $form->field($model, 'version_name')->textInput(['maxlength' => true]) ?>
                </div>
                <div class="form-group">
                    <?= $form->field($model, 'status')->dropDownList(UyeAppVersion::$status) ?>
                </div>
                <div class="form-group">
                    <?= $form->field($model, 'force_update')->dropDownList(UyeAppVersion::$forceUpdate) ?>
                </div>
                <div class="form-group">
                    <?= $form->field($model, 'desp')->textarea(['rows' => 6]) ?>
                </div>
                <div class="form-group" style="display: none" id="app_upload">
                    <label>安卓APP文件名</label>
                    <input type="text" class="form-control" name="UyeAppVersion[app_name]"
                           placeholder="请输入安卓APP文件名，APP包请通过SFTP上传至服务器">
                </div>
            </div>
        </div>
    </div>
    <div class="box-footer">
        <?= Html::submitButton($model->isNewRecord ? '创建' : '更新', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>
<script type="text/javascript">
    <?php $this->beginBlock('app_version')?>
    $(document).ready(function () {
        $('#uyeappversion-type').change(function () {
            var type = $(this).val();
            if (type == 2) {
                $('#app_upload').show();
            } else {
                $('#app_upload').hide();
            }
        });
    });
    <?php $this->endBlock() ?>
</script>


<?php
$this->registerJs($this->blocks['app_version'], \yii\web\View::POS_END);
?>

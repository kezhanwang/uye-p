<?php
/**
 * Created by PhpStorm.
 * User: wangyi
 * Date: 2017/11/8
 * Time: 下午3:17
 */


use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\widgets\ActiveForm;

$this->title = '添加课程';
$this->params['breadcrumbs'][] = $this->title;
$this->params['menu'] = $this->title;
\backend\assets\AppAsset::addCss($this, '/css/jquery.Jcrop.css');
\backend\assets\AppAsset::addJs($this, '/js/jquery.Jcrop.js');
\backend\assets\AppAsset::addJs($this, '/js/cut.kz.js');
?>

    <div class="box box-default">
        <div class="box-header with-border">
            <h3 class="box-title">课程信息</h3>
        </div>
        <?php $form = ActiveForm::begin([
            'options' => [
                'enctype' => 'multipart/form-data',
                'class' => 'form-horizontal'
            ]
        ]); ?>
        <input type="hidden" name="type" value="create">
        <div class="box-body">
            <div class="form-group">
                <label class="col-sm-2 control-label">机构名称:</label>
                <div class="col-md-10">
                    <input type="text" class="form-control" value="<?= $org['org_name']; ?>" readonly>
                    <input type="hidden" name="org_id" value="<?= $org['id']; ?>">
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label">课程名称:</label>
                <div class="col-md-10">
                    <input type="text" class="form-control" name="name" value="" placeholder="请输入课程名称">
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label">课程价格:</label>
                <div class="col-md-10">
                    <input type="text" class="form-control" name="unit_price" value="" placeholder="请输入课程价格，单位：元">
                </div>
            </div>
            <div class="form-group">
                <label class="col-md-2 control-label">课程logo：</label>
                <div class="col-md-10">
                    <span id="logoSpan" class="form-control" style="min-width: 100px;display: none"></span>
                    <img src="" style="display: none" id="logoshow">
                    <label for="logo">
                        <div class="btn btn-primary">浏览图片</div>
                    </label>
                </div>
            </div>

        </div>
        <!-- /.box-body -->
        <div class="box-footer">
            <?= Html::submitButton('保存', ['class' => 'btn btn-primary btn-sm']) ?>
        </div>
        <?php ActiveForm::end(); ?>
    </div>

    <script type="text/javascript">
        <?php $this->beginBlock('course');?>
        $(document).ready(function () {
            var logo = $('#logoSpan').cutKz({
                name: 'logo',
                url: '/org/upload',
            });
        });
        <?php $this->endBlock();?>
    </script>
<?php $this->registerJs($this->blocks['course'], \yii\web\View::POS_END); ?>
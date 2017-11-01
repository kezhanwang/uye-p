<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\UyeOrg */

$this->title = '新增机构';
$this->params['breadcrumbs'][] = ['label' => '新增机构', 'url' => ['index']];
$this->params['menu'] = $this->title;
$this->params['breadcrumbs'][] = $this->title;
\backend\assets\AppAsset::addJs($this, '/ueditor/ueditor.config.js');
\backend\assets\AppAsset::addJs($this, '/ueditor/ueditor.all.min.js');
\backend\assets\AppAsset::addJs($this, '/ueditor/lang/zh-cn/zh-cn.js');
\backend\assets\AppAsset::addCss($this, '/css/jquery.Jcrop.css');
\backend\assets\AppAsset::addJs($this, '/js/jquery.Jcrop.js');
\backend\assets\AppAsset::addJs($this, '/js/cut.kz.js');
?>

<div class="box box-default">
    <div class="box-header with-border">
        <h3 class="box-title">机构信息</h3>
    </div>
    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data', 'class' => 'form-horizontal']]); ?>
    <div class="box-body">
        <input type="hidden" name="type" value="ctrate">
        <div class="form-group">
            <label class="col-sm-2 control-label">机构名称:</label>
            <div class="col-md-10">
                <input type="text" class="form-control" name="org_name" placeholder="机构名称">
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-2 control-label">机构简称:</label>
            <div class="col-md-10">
                <input type="text" class="form-control" name="org_short_name" placeholder="机构简称">
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-2 control-label">机构类型:</label>
            <div class="col-md-10">
                <select class="form-control" name="org_type">
                    <?php foreach (\common\models\ar\UyeOrg::$orgType as $key => $item) { ?>
                        <option value="<?= $key; ?>"><?= $item; ?></option>
                    <?php } ?>
                </select>
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-2 control-label">就业帮服务:</label>
            <div class="col-md-10">
                <select class="form-control" name="is_employment">
                    <?php foreach (\common\models\ar\UyeOrg::$isEmployment as $key => $item) { ?>
                        <option value="<?= $key; ?>"><?= $item; ?></option>
                    <?php } ?>
                </select>
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-2 control-label">就业帮服务费率:</label>
            <div class="col-md-10">
                <div class="input-group">
                    <input type="text" class="form-control" name="employment_rate" value="0.00">
                    <span class="input-group-addon"><i>%</i></span>
                </div>
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-2 control-label">高薪帮服务:</label>
            <div class="col-md-10">
                <select class="form-control" name="is_high_salary">
                    <?php foreach (\common\models\ar\UyeOrg::$isHighSalary as $key => $item) { ?>
                        <option value="<?= $key; ?>"><?= $item; ?></option>
                    <?php } ?>
                </select>
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-2 control-label">商务人员:</label>
            <div class="col-md-10">
                <select class="form-control" name="org_type">

                </select>
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-2 control-label">机构地址:</label>
            <div class="col-md-10">
                <div class="col-sm-3">
                    <select class="form-control" name="province">
                        <option>请选择省份</option>
                    </select>
                </div>
                <div class="col-sm-3">
                    <select class="form-control" name="city">
                        <option>请选择城市</option>
                    </select>
                </div>
                <div class="col-sm-3">
                    <select class="form-control" name="area">
                        <option>请选择地区</option>
                    </select>
                </div>
            </div>

        </div>
        <div class="form-group">
            <label class="col-md-2 control-label"></label>
            <div class="col-md-10">
                <input type="text" class="form-control" name="address" placeholder="详细地址">
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-2 control-label">机构经纬度定位:</label>
            <div class="col-md-10">
                <div class="col-sm-4">
                    <div class="input-group">
                        <input type="text" class="form-control" name="map_lng">
                        <span class="input-group-addon"><i>经度</i></span>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="input-group">
                        <input type="text" class="form-control" name="map_lat">
                        <span class="input-group-addon"><i>纬度</i></span>
                    </div>
                </div>
                <div class="col-sm-2">
                    <a href="http://api.map.baidu.com/lbsapi/getpoint/index.html" target=" _blank"
                       class="btn btn-info btn-sm">百度坐标</a>
                </div>
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-2 control-label">机构电话:</label>
            <div class="col-md-10">
                <div class="input-group">
                    <input type="text" class="form-control" name="phone">
                    <span class="input-group-addon"><i class="fa fa-phone"></i></span>
                </div>
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-2 control-label">机构分类：</label>
            <div class="col-md-10">
                <select class="form-control" name="category_1">
                    <option value="0">请选择机构分类</option>

                </select>
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-2 control-label">机构logo：</label>
            <div class="col-md-10">
                <span id="logoSpan" class="form-control" style="min-width: 100px;display: none"></span>
                <img src="" style="display: none" id="logoshow">
                <label for="logo">
                    <div class="btn btn-primary">浏览图片</div>
                </label>
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-2 control-label">机构简介</label>
            <div class="col-md-10">
                <div style="display: inline-block;vertical-align: top;">
                    <div id="editor"></div>
                </div>
                <textarea class="form-control" name="desp" rows="15" style="width: 60%;display: none;"
                          id="desc"></textarea>
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
    <?php $this->beginBlock('org_create')?>
    $(document).ready(function () {
        function getProvince() {
            var csrfToken = $('meta[name="csrf-token"]').attr("content");
            $.ajax({
                type: "GET",
                url: '<?= DOMAIN_ADMIN;?>/site/province',
                data: {'_csrf': csrfToken},
                dataType: "json",
                success: function (responseData) {
                    if (responseData.code = 100) {
                        var str = '<option value="0">请选择省份...</option>';
                        for (var i = 0; i < responseData.data.length; i++) {
                            str += "<option value='" + responseData.data[i]['id'] + "'>" + responseData.data[i]['name'] + "</option>";
                        }
                        $('select[name="province"]').html(str);
                    }
                }
            });
        }

        getProvince();

        $('select[name="province"]').change(function () {
            var str = '<option value="0">请选择城市...</option>';
            var id = $(this).val();
            if (id == 0) {
                return true;
            }

            var csrfToken = $('meta[name="csrf-token"]').attr("content");
            $.ajax({
                type: "GET",
                url: '<?= DOMAIN_ADMIN;?>/site/city',
                data: {'province': id, '_csrf': csrfToken},
                dataType: "json",
                success: function (responseData) {
                    if (responseData.code = 100) {
                        for (var i = 0; i < responseData.data.length; i++) {
                            str += "<option value='" + responseData.data[i]['id'] + "'>" + responseData.data[i]['name'] + "</option>";
                        }
                        $('select[name="city"]').html(str);
                    }
                }
            });
        });

        $('select[name="city"]').change(function () {
            var str = '<option value="0">请选择地区...</option>';
            var id = $(this).val();
            if (id == 0) {
                return true;
            }

            var csrfToken = $('meta[name="csrf-token"]').attr("content");
            $.ajax({
                type: "GET",
                url: '<?= DOMAIN_ADMIN;?>/site/area',
                data: {'city': id, '_csrf': csrfToken},
                dataType: "json",
                success: function (responseData) {
                    if (responseData.code = 100) {
                        for (var i = 0; i < responseData.data.length; i++) {
                            str += "<option value='" + responseData.data[i]['id'] + "'>" + responseData.data[i]['name'] + "</option>";
                        }
                        $('select[name="area"]').html(str);
                    }
                }
            });
        });

        var ue = UE.getEditor('editor', {
            autoHeightEnabled: true,
        });

        var logo = $('#logoSpan').cutKz({
            name: 'logo',
            url: '/org/upload',
        });
    });
    <?php $this->endBlock() ?>
</script>


<?php
$this->registerJs($this->blocks['org_create'], \yii\web\View::POS_END);
?>

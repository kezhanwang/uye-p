<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use \common\models\ar\UyeOrg;

$this->title = "机构详情";
$this->params['breadcrumbs'][] = ['label' => '机构列表', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$this->params['menu'] = $this->title;
\backend\assets\AppAsset::addJs($this, "http://api.map.baidu.com/api?v=2.0&ak=NKfVIRMnqsDZ1iVHfxnnYOTHYw3m3G6e")
?>
<div class="row">
    <div class="col-md-3">
        <!-- Profile Image -->
        <div class="box box-primary">
            <div class="box-body box-profile">
                <img class="profile-user-img img-responsive img-circle" src="<?= $info_model->logo; ?>">

                <h3 class="profile-username text-center"><?= $model->org_name; ?></h3>

                <p class="text-muted text-center"><?= $model->org_short_name; ?></p>

                <ul class="list-group list-group-unbordered">
                    <li class="list-group-item">
                        <b>总校</b> <a class="pull-right"><?= $model->parent_id; ?></a>
                    </li>
                    <li class="list-group-item">
                        <b>类型</b> <a
                                class="pull-right"><?= UyeOrg::$orgType[$model->org_type]; ?></a>
                    </li>
                    <li class="list-group-item">
                        <b>状态</b> <a class="pull-right"><?= UyeOrg::$orgStatus[$model->status]; ?></a>
                        <?php if ($model->status == UyeOrg::STATUS_SAVE) { ?>
                            <button class="btn btn-info btn-sm "
                                    onclick="org_auth(<?= $model->id; ?>,<?= UyeOrg::STATUS_NO_AUDITED; ?>);">提交审核
                            </button>
                        <?php } else {
                            if ($model->status == UyeOrg::STATUS_NO_AUDITED) { ?>
                                <button class="btn btn-info btn-sm "
                                        onclick="org_auth(<?= $model->id; ?>,<?= UyeOrg::STATUS_OK; ?>);">通过
                                </button>
                                <button class="btn btn-info btn-sm "
                                        onclick="org_auth(<?= $model->id; ?>,<?= UyeOrg::STATUS_NO_PASS; ?>);">拒绝
                                </button>
                            <?php }
                        } ?>
                    </li>
                    <?php if ($model->status == UyeOrg::STATUS_OK) { ?>
                        <li class="list-group-item">
                            <b>上下架</b> <a class="pull-right"><?= UyeOrg::$isShelf[$model->is_shelf]; ?></a>
                            <?php if ($model->is_shelf == UyeOrg::IS_SHELF_ON) { ?>
                                <button class="btn btn-info btn-sm "
                                        onclick="org_shelf(<?= $model->id; ?>,<?= UyeOrg::IS_SHELF_OFF; ?>);">下架
                                </button>
                            <?php } else {
                                if ($model->is_shelf == UyeOrg::IS_SHELF_OFF) { ?>
                                    <button class="btn btn-info btn-sm "
                                            onclick="org_shelf(<?= $model->id; ?>,<?= UyeOrg::IS_SHELF_ON; ?>);">上架
                                    </button>
                                <?php }
                            } ?>
                        </li>
                    <?php } ?>

                    <li class="list-group-item">
                        <b>就业帮</b> <a
                                class="pull-right"><?= UyeOrg::$isEmployment[$model->is_employment]; ?></a>
                    </li>
                    <li class="list-group-item">
                        <b>高薪帮</b> <a
                                class="pull-right"><?= UyeOrg::$isHighSalary[$model->is_high_salary]; ?></a>
                    </li>
                </ul>
            </div>
            <!-- /.box-body -->
        </div>
        <!-- /.box -->
    </div>
    <!-- /.col -->
    <div class="col-md-9">
        <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
                <li class="active"><a href="#org_info" data-toggle="tab">机构信息</a></li>
                <li class=""><a href="#org_desp" data-toggle="tab">机构详情</a></li>
                <li class=""><a href="#org_course" data-toggle="tab">课程列表</a></li>
            </ul>
            <div class="tab-content">
                <div class="active tab-pane" id="org_info">
                    <table class="table table-bordered table-hover">
                        <tr>
                            <td>机构地址</td>
                            <td><?= $info_model->address ?></td>
                        </tr>
                        <tr>
                            <td>机构电话</td>
                            <td><?= $info_model->phone; ?></td>
                        </tr>
                        <tr>
                            <td>机构就业指数</td>
                            <td><?= $info_model->employment_index; ?></td>
                        </tr>
                        <tr>
                            <td>平均课程价格</td>
                            <td><?= '￥' . number_format(($info_model->avg_course_price / 100), 2); ?></td>
                        </tr>
                    </table>
                    <div class="row">
                        <div class="col-md-12">
                            <section class="panel">
                                <div class="panel-body">
                                    <input type="hidden" id="map_lat" value="<?= $info_model->map_lat ?>">
                                    <input type="hidden" id="map_lng" value="<?= $info_model->map_lng ?>">
                                    <div id="allmap" style="height: 400px;width: 100%;"></div>
                                </div>
                            </section>
                        </div>
                    </div>
                </div>
                <div class="tab-pane" id="org_desp">
                    <?= $info_model->description; ?>
                </div>
                <div class="tab-pane" id="org_course">
                    <table class="table table-bordered table-hover">
                        <thead>
                        <tr>
                            <td>课程id</td>
                            <td>课程名称</td>
                            <td>课程单价</td>
                        </tr>
                        </thead>
                        <?php foreach ($courses as $course) { ?>
                            <tr>
                                <td><?= $course['id']; ?></td>
                                <td><?= $course['name']; ?></td>
                                <td><?= '￥' . number_format(($course['unit_price'] / 100), 2); ?></td>
                            </tr>
                        <?php } ?>
                    </table>
                    <a class="btn btn-info btn-sm" href="/org/course?org_id=<?= $info_model->org_id; ?>" target="_blank">添加课程</a>
                </div>
            </div>
            <!-- /.tab-content -->
        </div>
        <!-- /.nav-tabs-custom -->
    </div>
    <!-- /.col -->
</div>
<!-- /.row -->
<script type="text/javascript">
    <?php $this->beginBlock('org');?>
    $(document).ready(function () {
        var map = new BMap.Map("allmap");
        map.centerAndZoom(new BMap.Point(116.331398, 39.897445), 11);
        map.enableScrollWheelZoom(true);
        map.clearOverlays();
        var new_point = new BMap.Point(document.getElementById("map_lng").value, document.getElementById("map_lat").value);
        var marker = new BMap.Marker(new_point);  // 创建标注
        map.addOverlay(marker);              // 将标注添加到地图中
        map.panTo(new_point);
        map.centerAndZoom(new_point, 15);
    });

    function org_auth(id, status) {
        var c = confirm('确认操作！');
        if (!c) {
            return false;
        } else {
            $.ajax({
                type: 'POST',
                url: '/org/auth',
                data: {
                    id: id,
                    status: status
                },
                dataType: 'json',
                success: function (responseData) {
                    if (responseData.code == 1000) {
                        alert("操作成功", '审核结果', function () {
                            history.go(0);
                        });
                    } else {
                        alert(responseData.msg);
                    }
                }
            });
        }
    }

    function org_shelf(id, shelf) {
        var c = confirm('确认操作！');
        if (!c) {
            return false;
        } else {
            $.ajax({
                type: 'POST',
                url: '/org/shelf',
                data: {
                    id: id,
                    shelf: shelf
                },
                dataType: 'json',
                success: function (responseData) {
                    if (responseData.code == 1000) {
                        alert("操作成功", '审核结果', function () {
                            window.location.href = "<?php echo $backurl;?>";
                        });
                    } else {
                        alert(responseData.msg);
                    }
                }
            });
        }
    }
    <?php $this->endBlock();?>
</script>
<?php $this->registerJs($this->blocks['org'], \yii\web\View::POS_END); ?>

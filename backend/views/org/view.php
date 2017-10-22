<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\UyeOrg */

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
                                    class="pull-right"><?= \common\models\ar\UyeOrg::$orgType[$model->org_type]; ?></a>
                        </li>
                        <li class="list-group-item">
                            <b>状态</b> <a
                                    class="pull-right"><?= \common\models\ar\UyeOrg::$orgStatus[$model->status]; ?></a>
                        </li>
                        <li class="list-group-item">
                            <b>上下架</b> <a
                                    class="pull-right"><?= \common\models\ar\UyeOrg::$isShelf[$model->is_shelf]; ?></a>
                        </li>
                        <li class="list-group-item">
                            <b>就业帮</b> <a
                                    class="pull-right"><?= \common\models\ar\UyeOrg::$isEmployment[$model->is_employment]; ?></a>
                        </li>
                        <li class="list-group-item">
                            <b>高薪帮</b> <a
                                    class="pull-right"><?= \common\models\ar\UyeOrg::$isHighSalary[$model->is_high_salary]; ?></a>
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

                        </table>
                    </div>
                </div>
                <!-- /.tab-content -->
            </div>
            <!-- /.nav-tabs-custom -->
        </div>
        <!-- /.col -->
    </div>
    <!-- /.row -->
<?php
$this->registerJs("
   $(document).ready(function(){ 
        var map = new BMap.Map(\"allmap\"); 
        map.centerAndZoom(new BMap.Point(116.331398,39.897445),11);
        map.enableScrollWheelZoom(true);
        map.clearOverlays();
        var new_point = new BMap.Point(document.getElementById(\"map_lng\").value,document.getElementById(\"map_lat\").value);
        var marker = new BMap.Marker(new_point);  // 创建标注
        map.addOverlay(marker);              // 将标注添加到地图中
        map.panTo(new_point);
        map.centerAndZoom(new_point, 15);
    });", \yii\web\View::POS_END);
?>
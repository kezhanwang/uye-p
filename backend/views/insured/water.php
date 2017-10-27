<?php
/**
 * Created by PhpStorm.
 * User: wangyi
 * Date: 2017/10/26
 * Time: 上午10:38
 */

use yii\helpers\Html;
use yii\widgets\Pjax;
use common\models\ar\UyeInsuredOrder;
use common\models\ar\UyeInsuredWater;

$this->title = '服务费核算';
$this->params['breadcrumbs'][] = $this->title;
$this->params['menu'] = $this->title;
?>


    <div class="box box-default">
        <div class="box-header with-border">
            <h3 class="box-title">搜索</h3>
            <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
            </div>
        </div>
        <form>
            <!-- /.box-header -->
            <div class="box-body">
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>机构</label>
                            <input class="form-control" type="text" name="org" placeholder="机构名称/分校ID/总校ID"
                                   value="<?= Yii::$app->request->get('org') ?>">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>是否核算</label>
                            <select class="form-control" name="status">
                                <option value="0">所有核算状态</option>
                                <?php foreach (\common\models\ar\UyeInsuredWater::$status as $key => $value) { ?>
                                    <option value="<?= $key; ?>" <?php if (Yii::$app->request->get('status') == $key) {
                                        echo "selected";
                                    } ?>><?= $value ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                    </div>
                    <div class="col-md-3">
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
                            <td>支付订单</td>
                            <td>总校</td>
                            <td>保单号</td>
                            <td>保单状态</td>
                            <td>操作用户</td>
                            <td>支付时间</td>
                            <td>支付金额</td>
                            <td>支付渠道</td>
                            <td>核算状态</td>
                            <td>操作</td>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($waters as $water) { ?>
                            <tr>
                                <td><?= $water['id']; ?></td>
                                <td><?= $water['org_name']; ?></td>
                                <td><?= $water['insured_order']; ?></td>
                                <td><?= UyeInsuredOrder::getInsuredStatusDesp($water['insured_status'], UyeInsuredOrder::CLIENT_ADMIN); ?></td>
                                <td><?= $water['uid']; ?>
                                <td><?= date('Y-m-d H:i:s', $water['pay_time']); ?></td>
                                <td><?= '￥' . number_format($water['pay_amount'] / 100, 2); ?></td>
                                <td><?= UyeInsuredWater::$paySource[$water['pay_source']]; ?></td>
                                <td><?= UyeInsuredWater::$status[$water['status']]; ?></td>
                                <td>
                                    <?php if ($water['insured_status'] == INSURED_STATUS_PAY) { ?>
                                        <button class="btn btn-success btn-sm" onclick="water(<?= $water['id']; ?>);">核算</button>
                                    <?php } ?>
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

    <script type="text/javascript">
        <?php $this->beginBlock('water');?>
        $(document).ready(function () {

        });

        function water(id) {
            var c = confirm('确认操作！');
            if (!c) {
                return false;
            }else{
                $.ajax({
                    type: 'POST',
                    url: '/insured/checkwater',
                    data: {
                        id: id,
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
<?php $this->registerJs($this->blocks['water'], \yii\web\View::POS_END); ?>
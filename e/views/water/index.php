<?php

use yii\helpers\Html;
use yii\widgets\Pjax;

$insuredStatus = \common\models\ar\UyeInsuredOrder::getInsuredStatusDesp();
$this->title = '资金流水';
$this->params['breadcrumbs'][] = $this->title;
$this->params['menu'] = $this->title;
\e\assets\AppAsset::addCss($this, "/js/bootstrap-datepicker/css/datepicker.css");
\e\assets\AppAsset::addJs($this, "/js/bootstrap-datepicker/js/bootstrap-datepicker.js");
?>
<div class="row">
    <div class="col-sm-12">
        <div class="panel panel-default">
            <div class="panel-heading">检索条件</div>
            <form class="form_inline" name="form1">
                <input type="hidden" name="excel" value="0"/>
                <div class="panel-body">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>支付时间</label>
                            <div class="input-group">
                                <input type="text" class="form-control selectDate" placeholder="起始时间" name="beginDate"
                                       value="<?= Yii::$app->request->get('beginDate'); ?>">
                                <div class="input-group-addon">~</div>
                                <input type="text" class="form-control selectDate" name="endDate" placeholder="结束时间"
                                       value="<?= Yii::$app->request->get('endDate'); ?>">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>支付方式</label>
                            <select class="form-control" name="pay_source">
                                <option value="0">所有</option>
                                <?php foreach (\common\models\ar\UyeInsuredWater::$paySource as $key => $val) { ?>
                                    <option value="<?= $key ?>" <?php if (Yii::$app->request->get('pay_source') == $key) {
                                        echo "selected";
                                    } ?>><?= $val; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">

                    </div>
                    <div class="col-md-3">

                    </div>
                </div>
                <div class="panel-footer">
                    <?= Html::submitButton('查询', ['class' => 'btn btn-primary btn-sm']) ?>
                    <?= Html::resetButton('重置', ['class' => 'btn btn-default btn-sm']) ?>
                    <input type="button" class="btn btn-default btn-sm"
                           onclick="document.getElementsByName('excel')[0].value=1;document.form1.submit();"
                           value="导出"/>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-sm-12">
        <div class="panel panel-default">
            <div class="panel-heading">保单列表</div>
            <div class="panel-body" style="overflow-x: auto;">
                <?php Pjax::begin(); ?>
                <table class="table  table-hover general-table">
                    <thead>
                    <tr>
                        <td>日期</td>
                        <td>订单数</td>
                        <td>支付金额</td>
                        <td class="operating">操作</td>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($data as $item) { ?>
                        <tr>
                            <td><?= $item['date']; ?></td>
                            <td><?= $item['total']; ?></td>
                            <td><?= "￥" . number_format($item['pay_amount'] / 100, 2); ?></td>
                            <td class="operating">
                                <button onclick="show('<?= $item['date']; ?>')" class="btn btn-sm btn-info">明细</button>
                            </td>
                        </tr>
                        <tr style="display: none;" id="<?= $item['date']; ?>">
                            <td colspan="4">
                                <table class="table table-hover general-table">
                                    <thead>
                                    <tr>
                                        <td>流水ID</td>
                                        <td>操作时间</td>
                                        <td>订单数</td>
                                        <td>支付时间</td>
                                        <td>机构</td>
                                        <td>操作人</td>
                                        <td>支付方式</td>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php if ($item['detail']) { ?>
                                        <?php foreach ($item['detail'] as $val) { ?>
                                            <tr>
                                                <td><?= $val['id']; ?></td>
                                                <td><?= date('Y-m-d H:i:s', $val['created_time']); ?></td>
                                                <td>1</td>
                                                <td><?= date('Y-m-d H:i:s', $val['created_time']); ?></td>
                                                <td><?= $val['org_name'] ?></td>
                                                <td><?= $val['username'] ?></td>
                                                <td><?= \common\models\ar\UyeInsuredWater::$paySource[$val['pay_source']]; ?></td>
                                            </tr>
                                        <?php } ?>
                                    <?php } ?>
                                    </tbody>
                                </table>
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
    <?php $this->beginBlock('selectDate')?>
    $(document).ready(function(){
        $('.selectDate').datepicker({
            setEndDate: '<?= date('Y-m-d')?>',
            todayBtn: false,
            format: 'yyyy-mm-dd',
            autoclose: true
        });
    });
    <?php $this->endBlock() ?>

    //window.__async.push(
    //    function () {
    //        $('.selectDate').datepicker({
    //            setEndDate: '<?//= date('Y-m-d')?>//',
    //            todayBtn: false,
    //            format: 'yyyy-mm-dd',
    //            autoclose: true
    //        });
    //    }
    //);

    function show(id) {
        console.log(id);
        var display = $('#' + id).css('display');
        console.log(display);
        if (display == 'none') {
            $('#' + id).css('display', 'table-row');
        } else {
            $('#' + id).css('display', 'none');
        }
    }
</script>
<?php $this->registerJs($this->blocks['selectDate'],\yii\web\View::POS_END); ?>
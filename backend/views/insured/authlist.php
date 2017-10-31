<?php
/**
 * Created by PhpStorm.
 * User: wangyi
 * Date: 2017/10/22
 * Time: 下午5:35
 */

use yii\helpers\Html;
use yii\widgets\Pjax;
use \common\models\ar\UyeInsuredOrder;

$this->title = '申请审批';
$this->params['breadcrumbs'][] = $this->title;
$this->params['menu'] = $this->title;
?>


<div class="box box-default">
    <div class="box-header with-border">
        <h3 class="box-title">搜索</h3>
        <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
        </div>
    </div>

    <form >
        <!-- /.box-header -->
        <div class="box-body">
            <div class="row">
                <div class="col-md-3">
                    <div class="form-group">
                        <label>个人信息</label>
                        <input class="form-control" type="text" name="key" placeholder="订单号/姓名/用户uid" value="<?= Yii::$app->request->get('key')?>">
                    </div>
                    <div class="form-group">
                        <label>手机号</label>
                        <input class="form-control" type="text" name="auth_mobile" placeholder="手机号" value="<?= Yii::$app->request->get('auth_mobile')?>">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label>机构</label>
                        <input class="form-control" type="text" name="org" placeholder="机构名称/分校ID/总校ID" value="<?= Yii::$app->request->get('org')?>">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label>订单类型</label>
                        <select class="form-control" name="insured_type">
                            <option value="0">所有订单类型</option>
                            <?php foreach (UyeInsuredOrder::$insuredType as $key=>$value){?>
                                <option value="<?= $key;?>" <?php if (Yii::$app->request->get('insured_type') == $key){ echo "selected";}?>><?= $value?></option>
                            <?php }?>
                        </select>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label>身份证号</label>
                        <input class="form-control" type="text" name="id_card" placeholder="身份证号" value="<?= Yii::$app->request->get('id_card')?>">
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
                            <td>单号</td>
                            <td>状态</td>
                            <td>姓名</td>
                            <td>分校</td>
                            <td>申请时间</td>
                            <td>支付时间</td>
                            <td>学费</td>
                            <td>服务费</td>
                            <td>操作</td>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($insureds as $key){?>
                            <tr>
                                <td><?= $key['insured_order']; ?></td>
                                <td><?= UyeInsuredOrder::getInsuredStatusDesp($key['insured_status'], UyeInsuredOrder::CLIENT_ADMIN); ?></td>
                                <td><?= $key['full_name'] . "<br>" . $key['id_card'] . "<br>" . $key['auth_mobile']; ?></td>
                                <td><?= $key['org_name'] . "<br>" . $key['c_name'] . "<br>" . $key['course_consultant']; ?></td>
                                <td><?= date('Y-m-d H:i:s', $key['created_time']); ?></td>
                                <td><?php
                                    if ($key['insured_status'] > INSURED_STATUS_VERIFY_REFUSE) {
                                        echo date('Y-m-d H:i:s', $key['created_time']);
                                    } else {
                                        echo "暂未支付";
                                    }
                                    ?>
                                </td>
                                <td><?= "￥" . number_format(($key['tuition'] / 100), 2) ?></td>
                                <td><?= "￥" . number_format(($key['premium_amount'] / 100), 2) ?></td>
                                <td>
                                    <a href="<?= \yii\helpers\Url::toRoute(['/insured/view', 'id' => $key['id']]) ?>"
                                       class="btn btn-info btn-sm">查看</a>
                                </td>
                            </tr>
                        <?php }?>
                        </tbody>
                    </table>
                <?= \yii\widgets\LinkPager::widget(['pagination' => $pages, 'firstPageLabel' => '首页', 'lastPageLabel' => '尾页',]); ?>
                <?php Pjax::end(); ?>
            </div>
        </div>
    </div>
</div>


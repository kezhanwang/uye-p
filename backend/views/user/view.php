<?php
/**
 * Created by PhpStorm.
 * User: wangyi
 * Date: 2017/10/31
 * Time: 下午3:59
 */

$this->title = "用户详情";
$this->params['breadcrumbs'][] = ['label' => '用户详情', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$this->params['menu'] = $this->title;
?>

<div class="row">
    <div class="col-md-12">
        <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
                <li class="active"><a href="#register" data-toggle="tab">注册信息</a></li>
                <li><a href="#identity" data-toggle="tab">实名信息</a></li>
                <li><a href="#contact" data-toggle="tab">联系信息</a></li>
                <li><a href="#mobile" data-toggle="tab">通讯录信息</a></li>
            </ul>
            <div class="tab-content">
                <div class="active tab-pane fade in" id="register">
                    <table class="table table-hover table-bordered table-striped">
                        <tbody>
                        <tr>
                            <td colspan="4" align="center">注册信息</td>
                        </tr>
                        <tr>
                            <td>用户UID</td>
                            <td><?= $user['uid']; ?></td>
                            <td>用户昵称</td>
                            <td><?= $user['username']; ?></td>
                        </tr>
                        <tr>
                            <td>登录手机号</td>
                            <td><?= $user['phone']; ?></td>
                            <td>账户状态</td>
                            <td><?= \common\models\ar\UyeUser::$status[$user['status']]; ?></td>
                        </tr>
                        <tr>
                            <td>注册时间</td>
                            <td><?= date('Y-m-d H:i:s', $user['created_time']); ?></td>
                            <td></td>
                            <td></td>
                        </tr>
                        </tbody>
                    </table>
                </div>
                <div class=" tab-pane fade in" id="identity">
                    <table class="table table-hover table-bordered table-striped">
                        <tbody>
                        <tr>
                            <td colspan="4" align="center">实名信息</td>
                        </tr>
                        <tr>
                            <td>姓名</td>
                            <td><?= $identity['full_name']; ?></td>
                            <td>身份证号</td>
                            <td><?= $identity['id_card']; ?></td>
                        </tr>
                        <tr>
                            <td>身份证有效期</td>
                            <td><?= $identity['id_card_start'] . "~" . $identity['id_card_end']; ?></td>
                            <td>地址</td>
                            <td><?= $identity['id_card_address']; ?></td>
                        </tr>
                        <tr>
                            <td>认证手机号</td>
                            <td><?= $identity['auth_mobile'] ?></td>
                            <td>银行卡</td>
                            <td><?= $identity['bank_card_number'] . "(" . $identity['open_bank'] . $identity['open_bank_code'] . ")" ?></td>
                        </tr>
                        <tr>
                            <td>身份证信息面</td>
                            <td>
                                <span class="mailbox-attachment-icon has-img">
                                    <img src="<?= $identity['id_card_info_pic']; ?>">
                                </span>
                            </td>
                            <td>身份证国徽面</td>
                            <td>
                                 <span class="mailbox-attachment-icon has-img">
                                    <img src="<?= $identity['id_card_nation_pic']; ?>">
                                </span>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
                <div class=" tab-pane fade in" id="contact">
                    <table class="table table-hover table-bordered table-striped">
                        <tbody>
                        <tr>
                            <td colspan="4" align="center">联系信息</td>
                        </tr>
                        <tr>
                            <td>电子邮箱</td>
                            <td><?= $contact['email']; ?></td>
                            <td>微信</td>
                            <td><?= $contact['wechat']; ?></td>
                        </tr>
                        <tr>
                            <td>QQ</td>
                            <td><?= $contact['qq']; ?></td>
                            <td>婚姻状况</td>
                            <td><?= $contact['marriage']; ?></td>
                        </tr>
                        <tr>
                            <td>家庭住址</td>
                            <td colspan="3" align="left"><?= $contact['home'] . $contact['home_address']; ?></td>
                        </tr>
                        <tr>
                            <td>紧急联系人</td>
                            <td><?= $contact['contact1_name'] . "(" . $contact['contact1_phone'] . ")" ?></td>
                            <td>电话</td>
                            <td><?= $contact['contact1_phone']; ?></td>
                        </tr>
                        </tbody>
                    </table>
                </div>
                <div class=" tab-pane fade in" id="mobile">
                    <table class="table table-hover table-bordered table-striped">
                        <thead>
                        <tr>
                            <td colspan="4" align="center">通讯录信息</td>
                        </tr>
                        <tr>
                            <td>姓名</td>
                            <td>手机号1</td>
                            <td>手机号2</td>
                            <td>手机号3</td>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($mobile as $item) { ?>
                            <tr>
                                <td><?= $item['firstname'] . $item['lastname']; ?></td>
                                <td><?= $item['mobile1']; ?></td>
                                <td><?= $item['mobile2']; ?></td>
                                <td><?= $item['mobile3']; ?></td>
                            </tr>
                        <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

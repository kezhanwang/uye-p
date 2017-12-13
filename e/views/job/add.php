<?php
/**
 * Created by PhpStorm.
 * User: wangyi
 * Date: 2017/12/12
 * Time: 上午10:16
 */


$this->title = '新增就业进展';
$this->params['breadcrumbs'][] = $this->title;
$this->params['menu'] = $this->title;
\e\assets\AppAsset::addCss($this, '/js/bootstrap-datepicker/css/datepicker-custom.css');
\e\assets\AppAsset::addCss($this, '/js/bootstrap-timepicker/css/timepicker.css');
\e\assets\AppAsset::addCss($this, '/js/bootstrap-colorpicker/css/colorpicker.css');
\e\assets\AppAsset::addCss($this, '/js/bootstrap-daterangepicker/daterangepicker-bs3.css');
\e\assets\AppAsset::addCss($this, '/js/bootstrap-datetimepicker/css/datetimepicker-custom.css');
\e\assets\AppAsset::addCss($this, '/js/dropzone/css/dropzone.css');
\e\assets\AppAsset::addCss($this, '/js/jquery-ui-1.12.1.custom/jquery-ui.min.css');
\e\assets\AppAsset::addCss($this, '/js/plupload/js/jquery.ui.plupload/css/jquery.ui.plupload.css');

?>
<div class="row">
    <div class="col-sm-12">
        <section class="panel">
            <header class="panel-heading">
                单号：<?= $insured['insured_order']; ?>
            </header>
            <form class="form-horizontal adminex-form">
                <input type="hidden" name="id" value="<?= $insured['id']; ?>">
                <div class="panel-body">
                    <div class="form-group">
                        <label class="col-sm-2 col-sm-2 control-label">时间</label>
                        <div class="col-md-10">
                            <div class="iconic-input right input-group custom-date-range">
                                <input type="text" class="form-control dpd1" name="date" data-date-format="yyyy-mm-dd">
                                <span class="help-block">请填写推荐时间，请勿晚于当前时间.</span>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 col-sm-2 control-label">推荐单位：地点</label>
                        <div class="col-sm-10">
                            <div class="input-group">
                                <select class="form-control m-bot15" id="work_province" name="work_province">
                                    <option value="">请选择省份</option>
                                </select>
                                <span class="input-group-addon">省</span>
                                <select class="form-control m-bot15" id="work_city" name="work_city">
                                    <option value="">请选择市</option>
                                </select>
                                <span class="input-group-addon">市</span>
                                <select class="form-control m-bot15" id="work_area" name="work_area">
                                    <option value="">请选择区</option>
                                </select>
                                <span class="input-group-addon">区</span>
                            </div>
                            <span class="help-block">请选择推荐单位所在省市区.</span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 col-sm-2 control-label">推荐单位：详细地址</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control tooltips" placeholder="请填写推荐单位详细地址，不含省市区"
                                   name="work_address"
                                   value="" maxlength="20">
                            <span class="help-block">请填写推荐单位详细地址，不含省市区，不能少于五个汉字.</span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 col-sm-2 control-label">推荐单位</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control tooltips" placeholder="请填写推荐单位" name="work_name"
                                   value="" maxlength="20">
                            <span class="help-block">请填写推荐单位名称，不能少于五个汉字.</span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 col-sm-2 control-label">推荐职位</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control tooltips" placeholder="请填写推荐职位" name="position"
                                   value="" maxlength="10">
                            <span class="help-block">请填写推荐职位，不能少于两个汉字.</span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 col-sm-2 control-label">月薪范围</label>
                        <div class="col-sm-10">
                            <select class="form-control m-bot15" id="monthly_income" name="monthly_income">
                                <option value="">请选择月薪范围</option>
                                <?php foreach ($monthly_income as $item) { ?>
                                    <option value="<?= $item; ?>"><?= $item; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 col-sm-2 control-label">是否录用</label>
                        <div class="col-lg-10">
                            <label class="checkbox-inline">
                                <input type="radio" id="is_hiring" value="1" name="is_hiring"> 成功就业
                            </label>
                            <label class="checkbox-inline">
                                <input type="radio" id="is_hiring" value="2" name="is_hiring"> 待定
                            </label>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 col-sm-2 control-label">推荐资料</label>
                        <div class="col-sm-10">
                            <div id="uploader">
                                <p>Your browser doesn't have Flash, Silverlight or HTML5 support.</p>
                            </div>
                            <input type="hidden" name="pic">
                            <span class="help-block">请上传面试邀请函、录用通知等证明推荐就业的资料.</span>
                        </div>
                    </div>
                </div>
            </form>
            <div class="panel-footer">
                <a class="bth btn-info btn-sm" href="javascript:void(0) " onclick="submit();">提交</a>
            </div>
        </section>
    </div>
</div>
<?php
\e\assets\AppAsset::addJs($this, '/js/bootstrap-datepicker/js/bootstrap-datepicker.js');
\e\assets\AppAsset::addJs($this, '/js/bootstrap-datetimepicker/js/bootstrap-datetimepicker.js');
\e\assets\AppAsset::addJs($this, '/js/bootstrap-daterangepicker/moment.min.js');
\e\assets\AppAsset::addJs($this, '/js/bootstrap-daterangepicker/daterangepicker.js');
\e\assets\AppAsset::addJs($this, '/js/bootstrap-colorpicker/js/bootstrap-colorpicker.js');
\e\assets\AppAsset::addJs($this, '/js/bootstrap-timepicker/js/bootstrap-timepicker.js');
\e\assets\AppAsset::addJs($this, '/js/pickers-init.js');
\e\assets\AppAsset::addJs($this, '/js/jquery-ui-1.12.1.custom/jquery-ui.min.js');
\e\assets\AppAsset::addJs($this, '/js/plupload/js/plupload.full.min.js');
\e\assets\AppAsset::addJs($this, '/js/plupload/js/jquery.ui.plupload/jquery.ui.plupload.js');
\e\assets\AppAsset::addJs($this, '/js/plupload/js/i18n/zh_CN.js');
?>
<script type="text/javascript">
    <?php $this->beginBlock('study_add')?>
    $(document).ready(function () {
        $("#uploader").plupload({
            // General settings
            runtimes: 'html5,flash,silverlight,html4',
            url: '/common/upload',
            // Maximum file size
            max_file_size: '2mb',
            max_file_count: 9,
            chunk_size: '10mb',
            // Specify what files to browse for
            filters: [
                {title: "Image files", extensions: "jpg,gif,png"},
            ],
            // Rename files by clicking on their titles
            rename: true,
            // Sort files
            sortable: true,
            // Enable ability to drag'n'drop files onto the widget (currently only HTML5 supports that)
            dragdrop: true,
            // Views to activate
            views: {
                list: true,
                thumbs: true, // Show thumbs
                active: 'thumbs'
            },
            // Flash settings
            flash_swf_url: '/js/plupload/js/Moxie.swf',
            // Silverlight settings
            silverlight_xap_url: 'http://rawgithub.com/moxiecode/moxie/master/bin/silverlight/Moxie.cdn.xap',
            multipart_params: {
                id: '<?= $_GET['id']?>'
            },
            init: {
                FilesAdded: function (up, files) {
                },
                UploadProgress: function (up, file) {
                },
                FileUploaded: function (up, file, result) {
                    console.log(result);
                    var cur_input = $("input[name='pic']");
                    var r = JSON.parse(result.response);
                    var str = cur_input.attr('value') ? cur_input.attr('value') : '';
                    str = str + ',' + r.data['file'];
                    cur_input.attr('value', str);
                },
                Error: function (up, err) {
                }
            }
        });

        function getProvince() {
            var csrfToken = $('meta[name="csrf-token"]').attr("content");
            $.ajax({
                type: "GET",
                url: '/common/province',
                data: {'_csrf': csrfToken},
                dataType: "json",
                success: function (responseData) {
                    if (responseData.code = 100) {
                        var str = '<option value="0">请选择省份...</option>';
                        for (var i = 0; i < responseData.data.length; i++) {
                            str += "<option value='" + responseData.data[i]['id'] + "'>" + responseData.data[i]['name'] + "</option>";
                        }
                        $('select[name="work_province"]').html(str);
                    }
                }
            });
        }

        getProvince();

        $('select[name="work_province"]').change(function () {
            var str = '<option value="0">请选择城市...</option>';
            var id = $(this).val();
            if (id == 0) {
                return true;
            }

            var csrfToken = $('meta[name="csrf-token"]').attr("content");
            $.ajax({
                type: "GET",
                url: '/common/city',
                data: {'province': id, '_csrf': csrfToken},
                dataType: "json",
                success: function (responseData) {
                    if (responseData.code = 100) {
                        for (var i = 0; i < responseData.data.length; i++) {
                            str += "<option value='" + responseData.data[i]['id'] + "'>" + responseData.data[i]['name'] + "</option>";
                        }
                        $('select[name="work_city"]').html(str);
                    }
                }
            });
        });

        $('select[name="work_city"]').change(function () {
            var str = '<option value="0">请选择地区...</option>';
            var id = $(this).val();
            if (id == 0) {
                return true;
            }

            var csrfToken = $('meta[name="csrf-token"]').attr("content");
            $.ajax({
                type: "GET",
                url: '/common/area',
                data: {'city': id, '_csrf': csrfToken},
                dataType: "json",
                success: function (responseData) {
                    if (responseData.code = 100) {
                        for (var i = 0; i < responseData.data.length; i++) {
                            str += "<option value='" + responseData.data[i]['id'] + "'>" + responseData.data[i]['name'] + "</option>";
                        }
                        $('select[name="work_area"]').html(str);
                    }
                }
            });
        });
    });

    function submit() {
        //获取时间
        var date = $("input[name='date']").val();
        var mydate = new Date();
        var mytime = mydate.toLocaleDateString(); //获取当前时间
        console.log("时间选择：" + date + ';当前时间：' + mytime)
        if (date == '' || date == undefined || !checkEndTime(date, mytime)) {
            alert("请选择时间", "提示", function () {
            });
            return false;
        }

        var work_province = $("select[name='work_province']").val();
        console.log("地址选择器-省份：" + work_province);
        if (work_province == '' || work_province == undefined || work_province <= 0) {
            alert("请选择推荐公司所在省份", "提示", function () {
            });
            return false;
        }

        var work_city = $("select[name='work_city']").val();
        console.log("地址选择器-城市：" + work_city);
        if (work_city == '' || work_city == undefined || work_city <= 0) {
            alert("请选择推荐公司所在城市", "提示", function () {
            });
            return false;
        }

        var work_area = $("select[name='work_area']").val();
        console.log("地址选择器-区域：" + work_area);
        if (work_area == '' || work_area == undefined || work_area <= 0) {
            alert("请选择推荐公司所在区域", "提示", function () {
            });
            return false;
        }

        var work_address = $("input[name='work_address']").val();
        console.log("公司详细地址：" + work_address + '；地址长度：' + work_address.length);
        if (work_address == '' || work_address == undefined || work_address.length < 5) {
            alert("请正确填写推荐单位详细地址，不能少于5个字", "提示", function () {
            });
            return false;
        }

        var work_name = $("input[name='work_name']").val();
        console.log("公司名称：" + work_name + '；名称长度：' + work_name.length);
        if (work_name == '' || work_name == undefined || work_name.length < 5) {
            alert("请正确填写推荐单位名称，不能少于5个字", "提示", function () {
            });
            return false;
        }
        var position = $("input[name='position']").val();
        console.log("推荐工作岗位：" + position + '；推荐工作岗位字符串长度：' + position.length);
        if (position == '' || position == undefined || position.length < 2) {
            alert("请正确填写推荐工作岗位，不能少于2个字", "提示", function () {
            });
            return false;
        }
        var monthly_income = $("select[name='monthly_income']").val();
        console.log("选择月薪范围：" + monthly_income);
        if (monthly_income == '' || monthly_income == undefined) {
            alert("请选择月薪范围", "提示", function () {
            });
            return false;
        }

        //获取学习进展状态
        var is_hiring = $("input[name='is_hiring']:checked").val();
        console.log("是否录用：" + is_hiring);
        if (is_hiring == '' || is_hiring == undefined) {
            alert("请选择是否录用", "提示", function () {
            });
            return false;
        }
        var pic = $("input[name='pic']").val();
        var csrfToken = $('meta[name="csrf-token"]').attr("content");
        $.ajax({
            type: "POST",
            url: '/job/add',
            data: {
                'id': $("input[name='id']").val(),
                date: date,
                work_province: work_province,
                work_city: work_city,
                work_area: work_area,
                work_address: work_address,
                work_name: work_name,
                position: position,
                monthly_income: monthly_income,
                is_hiring: is_hiring,
                pic: pic,
                type: '_add',
                '_csrf': csrfToken
            },
            dataType: "json",
            success:
                function (responseData) {
                    if (responseData.code == 1000) {
                        $('#myModal').modal('hide');
                        alert("操作成功", "提示", function () {
                            window.location.href = '/insured/view?id=' + $("input[name='id']").val();
                        });
                    } else {
                        $('#myModal').modal('hide');
                        alert(responseData.msg, "提示", function () {
                            history.go(0);
                        });
                    }
                }
        });
    }

    function checkEndTime(date, now) {
        var dateTime = new Date(date.replace("-", "/").replace("-", "/"));
        var nowTime = new Date(now.replace("-", "/").replace("-", "/"));
        if (nowTime < dateTime) {
            return false;
        }
        return true;
    }
    <?php $this->endBlock() ?>
</script>


<?php
$this->registerJs($this->blocks['study_add'], \yii\web\View::POS_END);
?>

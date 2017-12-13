<?php
/**
 * Created by PhpStorm.
 * User: wangyi
 * Date: 2017/12/12
 * Time: 上午10:16
 */


$this->title = '新增学习进展';
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
                    <label class="col-sm-2 col-sm-2 control-label">进展</label>
                    <div class="col-lg-10">
                        <label class="checkbox-inline">
                            <input type="radio" id="status" value="1" name="status"> 学习中
                        </label>
                        <label class="checkbox-inline">
                            <input type="radio" id="status" value="2" name="status"> 已毕业
                        </label>
                        <label class="checkbox-inline">
                            <input type="radio" id="status" value="3" name="status"> 再培训
                        </label>
                    </div>
                </div>
                <div class="form-group" id="train_time" style="display: none">
                    <label class="col-sm-2 col-sm-2 control-label">再培训</label>
                    <div class="col-md-4">
                        <div class="input-group input-large custom-date-range" data-date-format="yyyy-mm-dd">
                            <input type="text" class="form-control dpd1" name="start" data-date-format="yyyy-mm-dd">
                            <span class="input-group-addon">至</span>
                            <input type="text" class="form-control dpd2" name="end" data-date-format="yyyy-mm-dd">
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 col-sm-2 control-label">班级排名</label>
                    <div class="col-sm-10">
                        <select class="form-control m-bot15" id="ranking" name="ranking">
                            <option value="">请选择班级排名</option>
                            <option value="1">较差</option>
                            <option value="2">一般</option>
                            <option value="3">良好</option>
                            <option value="4">优秀</option>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 col-sm-2 control-label">测试分数</label>
                    <div class="col-sm-10">
                        <input type="number" class="form-control tooltips" placeholder="请填写测试分数" name="fraction"
                               value="" maxlength="10">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 col-sm-2 control-label">评语</label>
                    <div class="col-sm-10">
                        <textarea class="form-control popovers" maxlength="255" name="remark" id="remark"></textarea>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 col-sm-2 control-label">推荐资料</label>
                    <div class="col-sm-10">
                        <div id="uploader">
                            <p>Your browser doesn't have Flash, Silverlight or HTML5 support.</p>
                        </div>
                        <input type="hidden" name="pic">
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

        $(':radio').click(function () {
            var status_number = $(this).val();
            if (status_number == 3) {
                $('#train_time').show();
            } else {
                $('#train_time').hide();
            }
        });
    });

    function submit() {
        //获取学习进展状态
        var status = $("input[name='status']:checked").val();
        if (status == '' || status == undefined) {
            alert("请选择培训进展", "提示", function () {
            });
            return false;
        }
        console.log("选择培训进展状态：" + status);
        //如果是再培训，则需要检查校验培训的时间范围
        var startTime = '';
        var endTime = "";
        if (status == 3) {
            startTime = $("input[name='start']").val();
            endTime = $("input[name='end']").val();
            console.log("选择的再培训时间区间：" + startTime + "~" + endTime);
            if (startTime == undefined || startTime == '' || endTime == undefined || endTime == '') {
                alert("请填写再培训时间", "提示", function () {
                });
                return false;
            }

            if (!checkEndTime(startTime, endTime)) {
                alert("再培训结束时间不能晚于起始时间", "提示", function () {
                });
                return false;
            }
        }
        //检查班级排名
        var ranking = $("#ranking option:selected").val();
        console.log("选择的班级排名：" + ranking);
        if (ranking == '' || ranking == undefined) {
            alert("请选择班级排名", "提示", function () {
            });
            return false;
        }
        var fraction = $("input[name='fraction']").val();
        var remark = $('#remark').val();
        var pic = $("input[name='pic']").val();
        var csrfToken = $('meta[name="csrf-token"]').attr("content");
        $.ajax({
            type: "POST",
            url: '/study/add',
            data: {
                'id': $("input[name='id']").val(),
                status: status,
                startTime: startTime,
                endTime: endTime,
                ranking: ranking,
                fraction: fraction,
                remark: remark,
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
                            history.go(0);
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

    function checkEndTime(start, end) {
        var startTime = new Date(start.replace("-", "/").replace("-", "/"));
        var endTime = new Date(end.replace("-", "/").replace("-", "/"));
        if (endTime < startTime) {
            return false;
        }
        return true;
    }
    <?php $this->endBlock() ?>
</script>


<?php
$this->registerJs($this->blocks['study_add'], \yii\web\View::POS_END);
?>

(function ($, window, document, undefined) {
    //构造函数
    var CutTor = function(els, opt){
        this.$el = els,
        this.defaults = {
            name:'logo',
            url:'',
        },
        this.options = $.extend({}, this.defaults, opt)
    };
    //弹框模板
    CutTor.prototype = {
        HTML:   '<div class="modal-overlay" >'+
                    '<div class="row text-center">'+
                        '<div class="col-md-10 col-md-offset-1">'+
                            '<div class="jc-demo-box">'+
                                '<div class="row">'+
                                    '<div class="col-md-12 text-center">'+
                                        '<h3>裁剪</h1>'+
                                    '</div>'+
                                '</div>'+
                                '<div class="row">'+
                                    '<div class="img">'+
                                        '<img src="" id="target" />'+
                                    '</div>'+
                                    '<div class="">'+
                                        '<div id="preview-pane">'+
                                            '<div class="preview-container">'+
                                                '<img src="" class="jcrop-preview" />'+
                                            '</div>'+
                                        '</div>'+
                                        '<div class="clearfix"></div>'+
                                    '</div>'+
                                '</div>'+
                                '<div class="row">'+
                                    '<div class="col-md-12 text-center">'+
                                        '<a href="javascript:void(0)" class="btn btn-primary j_sub" >提交</a>'+
                                        '<a href="javascript:void(0)" class="btn btn-default j_can" >取消</a>'+
                                    '</div>'+
                                '</div>'+
                            '</div>'+
                        '</div>'+
                    '</div>'+
                '</div>',
        inputHtml:  '<form id="JJ_SEAT_form">'+
                        '<input type="file" name="JJ_SEAT" id="JJ_SEAT" class="form-control" style="display: none;">'+
                    '</form>',
        formHtml:   '<input type="hidden" id="form_JJ_SEAT" name="JJ_SEAT">'+
                    '<input type="hidden" id="JJ_SEAT_x" name="JJ_SEAT_x" >'+
                    '<input type="hidden" id="JJ_SEAT_y" name="JJ_SEAT_y" >'+
                    '<input type="hidden" id="JJ_SEAT_w" name="JJ_SEAT_w" >'+
                    '<input type="hidden" id="JJ_SEAT_h" name="JJ_SEAT_h" >  ',
        HTMLCSS:    '<style class="J_CUT_CSS">'+
                        '.modal-overlay{display: none;width: 100%;height:100%;position: fixed;top: 0;right: 0;left: 0;bottom: 0;background: rgba(0,0,0,0.5);overflow: hidden;z-index: 1000;}'+
                        '#preview-pane { display: block; position: absolute; z-index: 2000; top: 10px; right: -280px; padding: 6px; border: 1px rgba(0, 0, 0, .4) solid; background-color: white; -webkit-border-radius: 6px; -moz-border-radius: 6px; border-radius: 6px; -webkit-box-shadow: 1px 1px 5px 2px rgba(0, 0, 0, 0.2); -moz-box-shadow: 1px 1px 5px 2px rgba(0, 0, 0, 0.2); box-shadow: 1px 1px 5px 2px rgba(0, 0, 0, 0.2); }'+
                        '#preview-pane .preview-container { width: 240px; height: 180px; overflow: hidden; }'+
                        '.modal-overlay .jc-demo-box { text-align: left; margin: 8px auto; background: #fff; border: 1px solid #bbb; -webkit-border-radius: 4px; -moz-border-radius: 4px; border-radius: 4px; -webkit-box-shadow: 1px 1px 10px rgba(0,0,0,.25); -moz-box-shadow: 1px 1px 10px rgba(0,0,0,.25); box-shadow: 1px 1px 10px rgba(0,0,0,.25); padding: 4px 8px 8px; position: fixed;top:10%;left:20%;}'+
                        '.modal-overlay .img{ text-align: left; margin: 4px auto; background: #fff; border: 1px solid #bbb; -webkit-border-radius: 4px; -moz-border-radius: 4px; border-radius: 4px; -webkit-box-shadow: 1px 1px 10px rgba(0,0,0,.25); -moz-box-shadow: 1px 1px 10px rgba(0,0,0,.25); box-shadow: 1px 1px 10px rgba(0,0,0,.25); padding: 4px 8px 8px; }'+
                        '.modal-overlay .img{ padding: 8px; margin: 8px;}'+
                    '</style>',
        //模板写入
        temWeiting: function(){
            var self = this;
            if(!$('.J_CUT_CSS').length != 0){
                $('head').append(self.HTMLCSS);
            }
            var newFormHtml = self.formHtml.replace(/JJ_SEAT/g, self.options.name);
            var newInputHtml = self.inputHtml.replace(/JJ_SEAT/g, self.options.name);
            self.$el.parents('form').append(newFormHtml);
            if(!$('.modal-overlay').length != 0){
                self.$el.parents('body').after(self.HTML);
            }
            self.$el.parents('form').after(newInputHtml);

            self.eventBind(); 
        },
        //重新渲染inputHTML 和 HTML
        inputDom: function(){
            var self = this;
            var newInputHtml = this.inputHtml.replace(/JJ_SEAT/g, this.options.name);
            $('#'+self.options.name+'_form').remove();
            this.$el.parents('form').after(newInputHtml);
            $('.modal-overlay').remove();
            if(!$('.modal-overlay').length != 0){
                self.$el.parents('body').after(self.HTML);
            }
            self.eventBind();
        },
        //文件选择事件绑定
        eventBind: function(){
            var self = this;
            $('#'+self.options.name+'_form').on('change', function() {
                self.changeEvent();  
            });
            $('.j_sub').on('click', function(event) {
                $('.modal-overlay').hide();   
            });
            $('.j_can').on('click', function(event) {
                $('.modal-overlay').hide();
                var trr = $('.J_CUT_CSS').attr('data-cla')||"";
                $('#'+trr+'Span').html("");
                $('#form_'+trr).val('');
            });

        },
        changeEvent: function(){
            var self = this;
            var size = ($('#'+self.options.name+'')[0].files[0].size/1024).toFixed(2);
            if(size > 2*1024){
                alert('图片大小不能超过2M');
            }else{ 
                $('#'+self.options.name+'Span').html($('#'+self.options.name+'').val());
                var fd = new FormData(document.getElementById(self.options.name+'_form'));
                $.ajax({
                    processData: false, // tell jQuery not to process the data
                    contentType: false, // tell jQuery not to set contentType
                    type:'POST',
                    url:self.options.url,
                    data:fd,
                    dataType:'json',
                    success:function (data) {
                        self.inputDom();
                        $('#form_'+self.options.name+'').val(data);
                        $('.modal-overlay img').prop('src',data);
                        $('.J_CUT_CSS').attr('data-cla',self.options.name);
                        $('.modal-overlay').show();
                        self.jcrop(self);
                    }
                });
            }
        },
        //裁剪插件事件
        jcrop: function(self){
            var  jcrop_api,
                    boundx,
                    boundy,

                    // Grab some information about the preview pane
                    $preview = $('#preview-pane'),
                    $pcnt = $('#preview-pane .preview-container'),
                    $pimg = $('#preview-pane .preview-container img'),

                    xsize = $pcnt.width(),
                    ysize = $pcnt.height();

            $('#target').Jcrop({
                    onChange: updatePreview,
                    onSelect: updatePreview,
                    boxHeight:400,
                    boxWidth:600,
                    aspectRatio: xsize / ysize
            }, function() {
                // Use the API to get the real image size
                var bounds = this.getBounds();

                boundx = bounds[0];
                boundy = bounds[1];
                // Store the API in the jcrop_api variable
                jcrop_api = this;

                // Move the preview into the jcrop container for css positioning
                $preview.appendTo(jcrop_api.ui.holder);
            });

            function updatePreview(c) {
                if (parseInt(c.w) > 0) {
                    var rx = xsize / c.w;
                    var ry = ysize / c.h;

                    $('#'+self.options.name+'_x').val(c.x);
                    $('#'+self.options.name+'_y').val(c.y);
                    $('#'+self.options.name+'_w').val(c.w);
                    $('#'+self.options.name+'_h').val(c.h);

                    $pimg.css({
                        width: Math.round(rx * boundx) + 'px',
                        height: Math.round(ry * boundy) + 'px',
                        marginLeft: '-' + Math.round(rx * c.x) + 'px',
                        marginTop: '-' + Math.round(ry * c.y) + 'px'
                    });
                }
            };
        }
    };
    //插件中使用
    $.fn.cutKz = function(options){
        var CutModel = new CutTor(this, options);
        //调用初始化方法
        return  CutModel.temWeiting();
              
    }
    
})(jQuery, window, document)
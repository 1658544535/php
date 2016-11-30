require(['../config'], function(config){

	require(['jquery', 'baiduTP', 'jqForm'], function($, baidu, jqForm){

		$(function(){

            // 初始显示回复类型相应的内容
            typeChange($("#replay_type"));

            // 回复类型切换显示相应的内容
            $("#replay_type").on("change", function(){
            	typeChange(this);
            });

            // 添加新闻回复
            $("#news-add").on("click", function(){
            	var _this = this;
            	var num = $("#v-news .reply_form2").length;
	            var bt = baidu.template;
	            var html = bt('t:news-item',{});
	            $(_this).before(html);
	            $("#news-add").removeClass("error");
	            if(num >= 7){
	                $(_this).hide();
	            }
            });

	        // 删除新闻回复
	        $(document).on("click", ".reply_form2 .del", function(){
	        	var _this = this;
	            var num = $("#v-news .reply_form2").length;
	            $(_this).parent().remove();
	            if(num <= 8){
	                $("#news-add").show();
	            }
	        });

            // 图片预览
            $(document).on("change", ".upLoadImg input.file", function(){
                var _this = $(this);
                var url = _this.val();
                if (window.createObjectURL != undefined) { // basic
                    url = window.createObjectURL(_this.get(0).files[0]);
                } else if (window.URL != undefined) { // mozilla(firefox)
                    url = window.URL.createObjectURL(_this.get(0).files[0]);
                } else if (window.webkitURL != undefined) { // webkit or chrome
                    url = window.webkitURL.createObjectURL(_this.get(0).files[0]);
                }
                _this.next().children('img').attr("src", url);
                _this.parent().addClass("has");
                $(_this).parent().removeClass("error");
            });

            // 表单change时,去掉其错误边框
            $(document).on("change", ".form-control", function(){
                if($(this).val() != '') {
                    $(this).removeClass("error");
                }
            });

            // 提交表单
            $('#myForm').on("submit", function(){
                var _this = $(this);
                $(".form-control:hidden").each(function(index, el) {
                    if($(el).is(":hidden") || $(el).parent().is(":hidden")){
                        $(el).attr("disabled", true);
                    }
                });
                if(doValidate()){
                    _this.find(".submit .loading").show();
                    _this.find(".submit .main").hide();
                    _this.ajaxSubmit({
                        success: function (data) {
                            data = eval("(" + data + ")");
                            if (data.status) {
                                history.go(-1);
                            } else {
                                alert(data.info);
                                _this.find(".submit .loading").hide();
                                _this.find(".submit .main").show();
                            }
                        }
                    });
                }
                $(".form-control").attr("disabled", false);
                return false;
            });

        });

        /* 回复类型切换显示相应的内容 */
        function typeChange(_this) {
            var type = $(_this).val(),
                oText = $("#v-text"),
                oNews = $("#v-news");
            switch (type) {
                case "text": 
                    oText.show();
                    oNews.hide();
                    break;
                case "news": 
                    oText.hide();
                    oNews.show();
                    break;
                default: 
                    oText.hide();
                    oNews.hide();
                    break;
            }
        }

        /* 表单验证 */
        function doValidate() {
            var success = true;

            //表单不能为空
            $(".form-control:visible").each(function(index, el) {
                var _this = $(el);
                if(_this.val() == '') {
                    success = false;
                    _this.addClass("error");
                }
            });

            // 按钮类型为菜单对应的子菜单至少一个
            if($("#v-news").is(":visible") && $("#v-news .reply_form2").length <= 0){
                success = false;
                $("#news-add").addClass("error");
            }

            // 图片必须选
            if($("#v-news").is(":visible")){
                $(".upLoadImg").each(function(index, el) {
	                if(!$(el).hasClass("has")) {
	                    success = false;
	                    $(el).addClass("error");
	                }
	            });
            }

            return success;
        }

	});

});
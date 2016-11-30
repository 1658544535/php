requirejs(['../config'], function(config){

	require(['jquery', 'baiduTP', 'jqForm'], function($, baidu, jqForm){

		$(function(){

	        // 初始显示按钮类型相应的内容
	        setId();
	        $("select.form-control").each(function(index, el) {
	            typeChange(el);
	        });

	        // 按钮类型切换显示相应的内容
	        $(document).on("change", ".key-main select, .sub-key select", function(){
	        	typeChange(this);
	        });

	        // 添加一级菜单
	        $(document).on("click", ".form-submit .btn-add", function(){
	        	var _this = this;
	        	var oMenu = $(".wx-menu");

		        // 3个一级菜单
		        if(oMenu.length >= 2){
		            $(_this).hide();
		        }
		        if(oMenu.length >= 3){
		            return false;
		        }
		        var bt = baidu.template;
		        var html = bt('t:menu',{num: oMenu.length+1});
		        if(oMenu.length == 0){
		            $("#wechatMenuForm").prepend(html);
		        }else{
		            oMenu.last().after(html);
		        }
		        

		        var oSelect = $(".wx-menu").last().find(".key-main select.form-control");
		        typeChange(oSelect);
	        });

		    /* 删除一级菜单 */
		    $(document).on("click", ".key-main .btn-del", function(){
		    	var _this = this;
		        var oMenu = $(_this).parents(".wx-menu");
		        var oAdd = oMenu.siblings("a");

		        oMenu.remove();
		        setId();

		        if(oMenu.length <= 2){
		            oAdd.show();
		        }
		    });

	        // 添加二级菜单
	        $(document).on("click", ".wx-sub-menu .btn-add", function(){
	        	var _this = this;
	        	var oSubMenu = $(_this).parents(".v-menu");
		        var oSubMenuLen = oSubMenu.find(".wx-sub-menu li").length - 1;

		        // 5个二级菜单
		        if(oSubMenuLen >= 4){
		            $(_this).hide();
		        }
		        if(oSubMenuLen >= 5){
		            return false;
		        }
		        var bt = baidu.template;
		        var id = oSubMenu.parents(".wx-menu").data("id");
		        var html = bt('t:sub_menu',{num: id});
		        $(_this).parent().before(html);
		        $(_this).removeClass("error");

		        var oSelect = $(_this).parent().prev().find(".sub-key select.form-control");
		        typeChange(oSelect);
	        });

		    // 删除二级菜单
		    $(document).on("click", ".sub-value .btn-del", function(){
		    	var _this = this;
		        var oSubMenu = $(_this).parents("li");
		        var oAdd = $(_this).parents(".wx-sub-menu").find("li").last().find('a');

		        oSubMenu.remove();

		        if(oSubMenu.length <= 4){
		            oAdd.show();
		        }
		    });

            // 表单change时,去掉其错误边框
	        $(document).on("change", ".form-control", function(){
	            if($(this).val() != '') {
	                $(this).removeClass("error");
	            }
	        });

	        // ajax提交更新写入操作
	        $('#wechatMenuForm').on("submit", function(){
	            $(".form-control:hidden").each(function(index, el) {
	                if($(el).is(":hidden") || $(el).parent().is(":hidden")){
	                    // $(el).attr("disabled", true);
	                    $(el).val('');
	                }
	            });
	            var _this = $(this);
	            if(doValidate()){
	                $(".form-submit .btn").hide();
	                $(".form-submit .loading").show();
	                _this.ajaxSubmit({
	                    success: function (data) {
	                        data = eval("(" + data + ")");
	                        if (data.status) {
	                            $(".form-submit").hide();
	                            $('.wx-syn').show().removeClass("zoomOut").addClass("zoomIn");
	                        } else {
	                            alert(data.info);
	                            $(".form-submit .btn").show();
	                            $(".form-submit .loading").hide();
	                        }
	                        // $(".form-control").attr("disabled", false);
	                    }
	                });
	            }
	            return false;
	        });
	        

	        // ajax提交同步至微信端
	        var token = 'HAHAHA';
	        $(".wx-syn .btn-save").on("click", function(){
	            $(".wx-syn").removeClass("zoomIn").addClass("zoomOut");
	            $(".form-submit").show();
	            var url = 'wx_menu.php?act=pushToWechat&token=' + token ;
	            $.getJSON(url,function (data) {
	                if (data.status) {
	                    alert(data.info);
	                } else {
	                    alert('提交失败');
	                }
	                $(".form-submit .btn").show();
	                $(".form-submit .loading").hide();
	            });
	        });

	        // 取消同步至微信
	        $(".wx-syn .btn-cancel").on("click", function(){
	            $(".wx-syn").removeClass("zoomIn").addClass("zoomOut");
	            $(".form-submit .btn").show();
	            $(".form-submit .loading").hide();
	            $(".form-submit").fadeIn();
	        });

	    });


	    /* 按钮类型切换显示相应的内容 */
	    function typeChange(_this) {
	        var type = $(_this).val(),
	            ifSub = !!$(_this).parents(".sub-key").length;
	        var oAll, oSub, oClick, oView;
	        if(ifSub){
	            oAll = $(_this).parents(".sub-key").parent().find(".sub-value>div");
	            oClick = $(_this).parents(".sub-key").parent().find(".sub-value .v-click");
	            oView = $(_this).parents(".sub-key").parent().find(".sub-value .v-view");
	        }else{
	            oAll = $(_this).parents(".wx-menu").find(".value>div");
	            oSub = $(_this).parents(".wx-menu").find(".value>.v-menu");
	            oClick = $(_this).parents(".wx-menu").find(".value>.v-click");
	            oView = $(_this).parents(".wx-menu").find(".value>.v-view");
	        }
	        oAll.hide();
	        if (type == 'sub1' || type == 'sub2' || type == 'sub3' || type == 'sub' ) {
	            oSub.show();
	        } else if(type == "click"){
	            oClick.show();
	        }else if(type == "view"){
	            oView.show();
	        }
	    }

	    /* 删除一级菜单是更改id */
	    function setId() {
	        $(".wx-menu").each(function(index, el) {
	            var pair = "_" + $(el).data("id"),
	                rep = "_" + (index+1);
	            $(el).find(".form-control").each(function(index1, el1) {
	                var name = $(el1).attr("name");
	                name = name.replace(pair, rep);
	                $(el1).attr("name", name);
	            });
	        });
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

	        //按钮类型为菜单对应的子菜单至少一个
	        $(".v-menu:visible").each(function(index, el) {
	            var _this = $(el);
	            if(_this.find(".wx-sub-menu>li").length<=1) {
	                success = false;
	                _this.find(".wx-sub-menu>li").last().find("a").addClass("error");
	            }
	        });

	        return success;
	    }

	});

})

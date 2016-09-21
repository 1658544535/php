<!doctype html>
<html lang="zh">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1, user-scalable=no" />
<meta content="telephone=no" name="format-detection" />
<title><?php echo $site_name;?></title>
<link type="text/css" rel="stylesheet" href="/css/base.css" />
<link rel="stylesheet" type="text/css" href="/js/selectdate/mobile-select-date.min.css" />
<link type="text/css" rel="stylesheet" href="css/common.css">
<style>
	body{background:#fff;}
	#header{border:none;}
	.bing_warp .form_warp dl dd input{width:100%;text-align:center;text-indent:0;}
</style>
</head>
<body>
	<div id="header">
	    <a href="javascript:history.go(-1);" class="header_back"></a>
	</div>
	
	<div class="nr_warp">
		<div class="bing_warp">

			<div class="form_warp">
				<form action="user_binding" method="post" onsubmit="return doSubmit()">
		             <input type="hidden" name="act" value="info" />
		             <input type="hidden" name="openid" value="<?php echo $openid;?>" />

					<dl>
						<dd>
							<div class="bind-form-item">
								<input id="name" name="name" type="text" placeholder="给自己取个昵称吧"/>
							</div>
						</dd>
						<dd>
							<div class="bind-form-item">
								<input id="name" name="baby_name" type="text" placeholder="宝宝昵称"/>
							</div>
						</dd>
						<dd>
							<div class="bind-form-item">
								<p class="user_edit_select" data-title="宝宝性别" id="baby_sex" placeholder="宝宝性别">宝宝性别</p>
								<select name="baby_sex" class="hide">
									<option value="1">男宝宝</option>
									<option value="2">女宝宝</option>
								</select>
							</div>
						</dd>
						<dd>
							<div class="bind-form-item">
								<input name="baby_birthday" type="text" id="baby_birthday" placeholder="宝宝生日"/>
							</div>
						</dd>
					</dl>

					<div class="btn_warp">
						<input class="red_btn btn" type="submit" value="免费注册" />
					</div>

				</form>

			</div>
		</div>
	</div>


	<script type="text/javascript" src="/js/jquery-1.11.0.min.js"></script>
	<script type="text/javascript" src="/js/selectdate/zepto.min.js"></script>
	<script type="text/javascript" src="/js/dialog.min.js"></script>
	<script type="text/javascript" src="/js/selectdate/mobile-select-date.min.js"></script>
	<script type="text/javascript" src="/js/base.js"></script>
	<script>
		$(function(){
			//checkbox
			fn_g_checkbox();

			//选择生日
	        var babySelDate = new MobileSelectDate();
	        babySelDate.init({
	            trigger:'#baby_birthday',
	            value:'',
	            min:'',
	            max:'',
	            callback:function(obj){
	                var _objBirth = $("#baby_birthday");
	                _objBirth.val(_objBirth.val().replace(/\//g,"-"));
	            }
	        });

	        // $(".user_edit_select").each(function(index, el) {
	        //     var initValue = $(el).next().find("option:selected").html();
	        //     $(el).html(initValue);
	        // });

	        $(".user_edit_select").on("click",function(){
	            var _this = $(this);
	            var aHtml = '<div class="m_select" id="m_select">'
	                      +    '<div class="m_select_bg" onclick="m_select_close()"></div>'
	                      +    '<div class="m_select_main animate_moveUp">'
	                      +        '<dl>'
	                      +           '<dt>'+ $(this).attr("data-title") +'</dt>';

	            _this.next().find("option").each(function(index, el) {
	                aHtml +=       '<dd onclick="m_select_choose(this,'+ index +')"data-aim="#' + _this.attr("id") + '">'+ $(el).html() +'</dd>'
	            });

	                aHtml +=        '</dl>'
	                      +        '<a href="javascript:m_select_close();" class="m_select_close">取消</a>'
	                      +    '</div>'
	                      +'</div>';
	            $("body").append(aHtml);
	        });

		});
		function m_select_choose(obj,index){
	        var aim = $(obj).attr("data-aim");
	        $(aim).html($(obj).html());
	        $(aim).next().find("option").attr("selected",false);
	        $(aim).next().find("option").eq(index).attr("selected",true);
	        $("#baby_sex").addClass("active");
	        m_select_close();
	    }
	    function m_select_close(){
	        $(".m_select_main").removeClass("animate_moveUp").addClass("animate_moveDown");
	        setTimeout(function(){
	            $("#m_select").remove();
	        },200);
	    }

	    function doSubmit(){
	        if($("#name").val() == ""){
	            alert("请填写昵称");
	            return false;
	        }

	        if($("#baby_sex").html() == "宝宝性别"){
	            alert("请选择宝宝性别");
	            return false;
	        }

	        var isBirth = true;
	        var birth = $("#baby_birthday").val();
	        var arrBirth = birth.split("-");
	        for(var i=0,_len=arrBirth.length; i<_len; i++){
	            if(arrBirth[i] == ""){
	                isBirth = false;
	                break;
	            }
	        }
	        if(!isBirth){
	            alert("请正确选择出生日期");
	            return false;
	        }
	    }
	</script>

</body>
</html>

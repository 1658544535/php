<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title><?php echo $site_name;?></title>
    <meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, minimal-ui, user-scalable=0" name="viewport">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <link rel="stylesheet" href="css/sm.min.css">
    <link rel="stylesheet" href="css/all.min.css">
</head>

<body>
    <div class="page-group" id="page-login">
        <div id="page-nav-bar" class="page page-current">
            <header class="bar bar-nav">
                <a class="button button-link button-nav pull-left back" href="">
                    <span class="icon icon-back"></span>
                </a>
                <h1 class="title">手机登录</h1>
            </header>

            <div class="content">
                <form action="user_binding" method="post" onsubmit="return tgSubmit()">
					<input type="hidden" name="openid" value="<?php echo $openid;?>" />
                    <section class="edit-list-icon">
                        <ul class="list">
                            <li>
                                <i class="icon icon-tel"></i>
                                <div class="input-controll"><input type="text" name="mobile" id="mobile" class="txt" placeholder="手机号码" /></div>
                            </li>
                            <li>
                                <i class="icon icon-code"></i>
                                <div class="input-controll"><input type="text" name="code" id="code" class="txt" placeholder="验证码" /></div>
                                <a href="javascript:;" class="btn" id="JS-vcodebtn" onclick="show_captcha()">发送验证码</a>
								<span id='tip' style="font-size:12px; padding-left:10px;" ><span id="time">60</span> 秒后重发</span>
                            </li>
                        </ul>
						<div id="captcha" style="margin:0 10px;"></div>
                    </section>

                    <div class="bin-btn">
                        <input type="submit" value="登录" />
                    </div>
                </form>
            </div>
            

        </div>
    </div>
    <script type='text/javascript' src='js/zepto.js' charset='utf-8'></script>
    <script type='text/javascript' src='js/sui/sm.min.js' charset='utf-8'></script>
    <script type='text/javascript' src='js/app.min.js' charset='utf-8'></script>
	<script src="http://static.geetest.com/static/tools/gt.js"></script>
	<script type="text/javascript">
		$(function(){
			$("#tip").hide();
		})

		function get_code( v_geetest_challenge, v_geetest_validate, v_geetest_seccode,captchaObj  )
		{
			$.ajax({
				type: "POST",
				dataType: "json",
             	url: "/user_registered?act=get_code&tel=" + $("#mobile").val(),
             	data:{
	          			'geetest_challenge' :  v_geetest_challenge,
						'geetest_validate'  :  v_geetest_validate,
						'geetest_seccode'   :  v_geetest_seccode
	          	},
             	success: function(data){
             		if(data.code > 0){
             			alert("验证码发送成功！");
         				$(".code_btn").hide();
         				$("#tip").show();
         				getclock();
         				$("#captcha").empty();
             		}else{
             			alert(data.msg);
             			captchaObj.refresh();
             			// show_captcha();
             		}
                }
			})
		}

		// 计时器
		function getclock()
		{
			var seconds = 0;
			var time = setInterval(function(){
				seconds += 1;
				document.getElementById('time').innerHTML = 60-seconds;

				if (seconds == 60)
				{
					$(".code_btn").show();
             		$("#tip").hide();
             		document.getElementById('time').innerHTML = 60;
             		 clearTimeout(time);
				}
			},1000);
		}

		function tgSubmit()
		{
			var mobile=$("#mobile").val();
			if($.trim(mobile) == "")
			{
				alert('请输入帐号');
				return false;
			}

			var code=$("#code").val();
			if($.trim(code) == "")
			{
				alert('请输入验证码');
				return false;
			}

			return true;
		}


		//验证码
		function handler(captchaObj) {
			$("#captcha").empty();
	        // 将验证码加到id为captcha的元素里
	        // captchaObj.appendTo("#captcha");
	        captchaObj.appendTo("#captcha");

	        captchaObj.onSuccess(function() {
				var v_geetest_challenge = $('.geetest_challenge').val();
	        	var v_geetest_validate = $('.geetest_validate').val();
	        	var v_geetest_seccode = $('.geetest_seccode').val();

	        	get_code( v_geetest_challenge, v_geetest_validate, v_geetest_seccode, captchaObj );
	        });
	    };
	    var xhr = "";
	    function show_captcha(){
			var mobile = $.trim($("#mobile").val());
			if(mobile == ""){
				alert("请输入手机号");
				return false;
			}else if(!_checkMobile(mobile)){
				alert("请正确输入手机号");
				return false;
			}
	     	if(!!xhr){
	     		$("#captcha").html("");
				xhr.abort();		//取消未请求完成的ajax
			}
	     	xhr = $.ajax({
		        // 获取id，challenge，success（是否启用failback）
		        url: "/validate.php?act=init_geetest",
		        type: "get",
		        dataType: "json", // 使用jsonp格式
		        success: function (data) {
		            // 使用initGeetest接口
		            // 参数1：配置参数，与创建Geetest实例时接受的参数一致
		            // 参数2：回调，回调的第一个参数验证码对象，之后可以使用它做appendTo之类的事件
		            $("#captcha").html("");
		            initGeetest({
		                gt: data.gt,
		                challenge: data.challenge,
		                product: "embed", // 产品形式embed
		                offline: !data.success,
		                width: "100%"
		            }, handler);
		        }
		    });
	    }

		function _checkMobile(_mobile){
			var re = /^1\d{10}/;
			return re.test(_mobile);
		}
	</script>
</body>

</html>




































<?php
/**
<!doctype html>
<html lang="zh">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1, user-scalable=no" />
<title><?php echo $site_name;?></title>
<link href="/css/common.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="/js/jquery-1.11.0.min.js"></script>
<script type="text/javascript" src="js/jquery.cycle.all.js"></script>
<script src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>
<script type="text/javascript" src="/js/wxshare.js"></script>
<style type="text/css">
	.forget-pwd{float:left;}
	.bing_warp .form_warp{margin-bottom:20px;}
	.bing_warp .form_warp dl dd label{font-size:16px; font-family:黑体;}
	#phone,#password{background:url(../images/user/user.png) no-repeat 0 center;background-size:21px auto;text-indent:35px;}
	#password{background-image:url(../images/user/pwd.png);}
</style>
<script>
	wxshare( <?php echo WXJSDEBUG;?>, '<?php echo WXJSAPPID;?>', <?php echo WXJSTIMESTAMP;?>, '<?php echo WXJSNONCESTR;?>', '<?php echo WXJSSIGNATURE;?>', '<?php echo WEBLOGO;?>', '<?php echo $SHARP_URL;?>', '<?php echo WEBTITLE;?>', '<?php echo WEBDESC;?>' )
</script>
</head>

<body style="background:#fff;">
	<div id="header">
	    <a href="javascript:history.go(-1);" class="header_back"></a>
	    <p class="header_title">登录淘竹马</p>
	</div>

	<div class="nr_warp">
		<div class="bing_warp">

			<div class="form_warp">
				<form action="user_binding" method="post" onsubmit="return tgSubmit()">
					<input type="hidden" name="act" value="bind" />
					<input type="hidden" name="openid" value="<?php echo $openid;?>" />

					<dl>
						<dd>
							<div class="bind-form-item">
								<input id="phone" name="phone" type="text" placeholder="请输入手机号"/>
							</div>
						</dd>

						<dd>
							<div class="bind-form-item">
								<input id="code" name="code" type="text" placeholder="请输入验证码" maxlength=6 style="width:40%; border-bottom:0;" />
								<a id="JS-vcodebtn" class="code_btn" onclick="show_captcha()">获取验证码</a>
								<span id='tip' style="font-size:12px; padding-left:10px;" ><span id="time">60</span> 秒后重发</span>
							</div>
						</dd>
<!--
						<dd>
							<div class="bind-form-item">
								<input id="password" name="password" type="password" placeholder="请输入密码" />
							</div>
						</dd>
					</dl>
-->
					<div class="btn_warp">
						<input class="red_btn btn" type="submit" value="登录" />
					</div>

				</form>
			</div>
		</div>
	</div>

	<?php include "footer_web.php";?>

	<script>
		$(function(){
			$("#tip").hide();
		})

		function get_code( v_geetest_challenge, v_geetest_validate, v_geetest_seccode,captchaObj  )
		{
			$.ajax({
				type: "POST",
				dataType: "json",
             	url: "/user_registered?act=get_code&tel=" + $("#phone").val(),
             	data:{
	          			'geetest_challenge' :  v_geetest_challenge,
						'geetest_validate'  :  v_geetest_validate,
						'geetest_seccode'   :  v_geetest_seccode
	          	},
             	success: function(data){
             		if(data.code > 0){
             			alert("验证码发送成功！");
         				$(".code_btn").hide();
         				$("#tip").show();
         				getclock();
         				$("#captcha").empty();
             		}else{
             			alert(data.msg);
             			captchaObj.refresh();
             			// show_captcha();
             		}
                }
			})
		}

		// 计时器
		function getclock()
		{
			var seconds = 0;
			var time = setInterval(function(){
				seconds += 1;
				document.getElementById('time').innerHTML = 60-seconds;

				if (seconds == 60)
				{
					$(".code_btn").show();
             		$("#tip").hide();
             		document.getElementById('time').innerHTML = 60;
             		 clearTimeout(time);
				}
			},1000);
		}

		function tgSubmit()
		{
			var phone=$("#phone").val();
			if($.trim(phone) == "")
			{
				alert('请输入帐号');
				return false;
			}

			var code=$("#code").val();
			if($.trim(code) == "")
			{
				alert('请输入验证码');
				return false;
			}

			var password=$("#password").val();
			if($.trim(password) == "")
			{
				alert('请输入密码');
				return false;
			}

			return true;
		}


		//验证码
		function handler(captchaObj) {
			$("#captcha").empty();
	         // 将验证码加到id为captcha的元素里
	         // captchaObj.appendTo("#captcha");
	         captchaObj.appendTo("#captcha");

	         captchaObj.onSuccess(function() {
	        	 var v_geetest_challenge = $('.geetest_challenge').val();
	        		var v_geetest_validate = $('.geetest_validate').val();
	        		var v_geetest_seccode = $('.geetest_seccode').val();

	        		get_code( v_geetest_challenge, v_geetest_validate, v_geetest_seccode, captchaObj );
	          });
	     };
	     var xhr = "";
	     function show_captcha(){
	     	if(!!xhr){
	     		$("#captcha").html("");
				xhr.abort();		//取消未请求完成的ajax
			}
	     	xhr = $.ajax({
		        // 获取id，challenge，success（是否启用failback）
		        url: "/validate.php?act=init_geetest",
		        type: "get",
		        dataType: "json", // 使用jsonp格式
		        success: function (data) {
		            // 使用initGeetest接口
		            // 参数1：配置参数，与创建Geetest实例时接受的参数一致
		            // 参数2：回调，回调的第一个参数验证码对象，之后可以使用它做appendTo之类的事件
		            $("#captcha").html("");
		            initGeetest({
		                gt: data.gt,
		                challenge: data.challenge,
		                product: "embed", // 产品形式embed
		                offline: !data.success,
		                width: "100%"
		            }, handler);
		        }
		    });
	     }

	</script>

</body>
</html>
*/
?>
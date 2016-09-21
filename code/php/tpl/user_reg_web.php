<!doctype html>
<html lang="zh">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1, user-scalable=no" />
<title><?php echo $site_name;?></title>
<link href="/css/common.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="/js/jquery-1.11.0.min.js"></script>
<script src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>
<script type="text/javascript" src="/js/wxshare.js"></script>
<style type="text/css">
	.bing_warp .form_warp{margin-bottom:0;}
	.bing_warp .form_warp dl dd label{font-size:16px; font-family:黑体;}
	.bing_warp .form_warp dl dd input{font-size:14px; border-bottom:0;}
	.bing_warp .btn_warp{margin-left:15px;margin-right:15px;}
	.code_btn{margin:12px 20px;color:#333; border:1px #f72418 solid; border-radius:8px; padding:1px 8px; font-size:14px; float:right;}
</style>
<script>
	wxshare( <?php echo WXJSDEBUG;?>, '<?php echo WXJSAPPID;?>', <?php echo WXJSTIMESTAMP;?>, '<?php echo WXJSNONCESTR;?>', '<?php echo WXJSSIGNATURE;?>', '<?php echo WEBLOGO;?>', '<?php echo $SHARP_URL;?>', '<?php echo WEBTITLE;?>', '<?php echo WEBDESC;?>' )
</script>
</head>

<body style="background:#fff;">
	<div id="header">
	    <a href="javascript:history.go(-1);" class="header_back"></a>
	    <p class="header_title">注册</p>
	</div>

	<div class="nr_warp">
		<div class=" bing_warp">

			<div class="form_warp">
				<form action="user_binding" method="post" onsubmit="return tgSubmit()">
					<input type="hidden" name="act" value="reg" />
					<input type="hidden" name="openid" value="<?php echo $openid;?>" />

					<dl>
						<dd>
							<div class="bind-form-item">
<!-- 								<label>手机号　</label> -->
								<input id="phone" name="phone" type="text" placeholder="请输入手机号"/>
							</div>
						</dd>

						<dd>
							<div class="bind-form-item">
<!-- 								<label>验证码　</label> -->
								<input id="code" name="code" type="text" placeholder="请输入验证码" maxlength=6 style="width:40%; border-bottom:0;" />
								<a id="JS-vcodebtn" class="code_btn" onclick="show_captcha()">获取验证码</a>
								<span id='tip' style="font-size:12px; padding-left:10px;" ><span id="time">60</span> 秒后重发</span>
							</div>
						</dd>

						<div id="captcha" style="margin:0 10px;"></div>

						<dd>
							<div class="bind-form-item">
<!-- 								<label>密　码　</label> -->
								<input id="password" name="password" type="password" placeholder="请输入6-12位密码" />
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

	<?php include "footer_web.php";?>

	<script src="http://static.geetest.com/static/tools/gt.js"></script>
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

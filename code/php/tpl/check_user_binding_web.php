<html xmlns="http://www.w3.org/1999/xhtml" lang="zh-CN">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta charset="utf-8" name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" />
	<title><?php echo $site_name;?></title>
	<link href="css/index4.css" rel="stylesheet" type="text/css" />
	<link href="/css/common.css" rel="stylesheet" type="text/css" />
	<script type="text/javascript" src="js/jquery-1.4.2.min.js"></script>
	<script type="text/javascript" src="js/jquery.cycle.all.js"></script>
	<script src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>
	<script type="text/javascript" src="/js/wxshare.js"></script>
	<script>
		wxshare( <?php echo WXJSDEBUG;?>, '<?php echo WXJSAPPID;?>', <?php echo WXJSTIMESTAMP;?>, '<?php echo WXJSNONCESTR;?>', '<?php echo WXJSSIGNATURE;?>', '<?php echo WEBLOGO;?>', '<?php echo $SHARP_URL;?>', '<?php echo WEBTITLE;?>', '<?php echo WEBDESC;?>' )
	</script>
</head>

<body>
	<div id="header">
		<!-- <a href="javascript:window.history.back(-1);" class="back"></a> -->
		<div id="text">绑定手机号</div>
	</div>

	<div class="nr_warp">
		<div class=" bing_warp">
			<div class="bingding_icon">
				<img src="/images/user/binding.png" />
			</div>

			<div class="form_warp">
				<form action="user_binding" method="post" onsubmit="return tgSubmit()">
					<input type="hidden" name="act" value="check_binding_post" />
					<input type="hidden" name="openid" value="<?php echo $openid;?>" />
					<input type="hidden" name="unionid" value="<?php echo $obj_user->unionid;?>" />

					<dl>
						<dd>
							<label>验证码　</label>
							<input id="code" name="code" type="text" placeholder="请输入验证码" maxlength=6 style="width:55%;" />
		   		  			<a onclick='get_code()'>获取验证码</a>
		   		  			<span id='tip' style="font-size:12px; padding-left:10px;" ><span id="time">60</span> 秒后重新发送</span>
						</dd>

						<dd>
							<label>密　码　</label>
							<input id="password" name="password" type="text" placeholder="请输入密码" style="width:70%;" />
						</dd>
					</dl>

					<div class="btn_warp">
						<input class="red_btn btn" type="submit" value="完成绑定" />
					</div>
				</form>
			</div>
		</div>

	</div>



	</br>
	</br>
	</br>
	</br>
	<?php include "footer_web.php";?>
	</br>
	</br>
	<?php include "footer_menu_web_tmp.php"; ?>


	<script type="text/javascript">
			$(function(){
				$("#tip").hide();
			})

			function get_code()
			{
				$.ajax({
					type: "GET",
	             	url: "/user_registered?act=get_code&tel=" + $("#tel").val(),
	             	success: function(data){
	             		switch(data)
	             		{
	             			case "-4":
	             				alert("验证码发送失败！");
	             			break;

	             			case "-3":
	             				alert("此手机号已被注册！");
	             			break;

	             			case "-2":
	             				alert("请输入正确的手机号码！");
	             			break;

	             			case "-1":
	             				alert("1分钟内不要频繁发送！");
	             			break;

	             			case "1":
	             				alert("验证码发送成功！");
	             				$(".code_btn").hide();
	             				$("#tip").show();
	             				getclock();
	             			break;
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

			function tgSubmit(){
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
		</script>

</body>
</html>

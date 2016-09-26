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
<!-- 								<label>手机号　</label> -->
								<input id="phone" name="phone" type="text" placeholder="请输入手机号"/>
							</div>
						</dd>

						<dd>
							<div class="bind-form-item">
<!-- 								<label>密　码　</label> -->
								<input id="password" name="password" type="password" placeholder="请输入密码" />
							</div>
						</dd>
					</dl>

					<div class="btn_warp">
						<input class="red_btn btn" type="submit" value="登录" />
					</div>

				</form>

				<div class="bing_other">
					<a href="/forget.php" class="forget-pwd">忘记密码？</a>
					<a href="/user_binding.php?act=user_reg">注册</a>
				</div>

			</div>
		</div>
	</div>

	<?php include "footer_web.php";?>

	<script>

		function tgSubmit()
		{
			var phone=$("#phone").val();
			if($.trim(phone) == "")
			{
				alert('请输入帐号');
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

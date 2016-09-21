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
	.bing_warp .link_btn_warp{margin:15px 0;}
	.bing_warp .link_btn_warp .red_btn{border-radius:8px;}
	.bing_warp .form_warp{margin-bottom:0;}
	.nr_warp p.tip{text-align:center;}
</style>
<script>
	wxshare( <?php echo WXJSDEBUG;?>, '<?php echo WXJSAPPID;?>', <?php echo WXJSTIMESTAMP;?>, '<?php echo WXJSNONCESTR;?>', '<?php echo WXJSSIGNATURE;?>', '<?php echo WEBLOGO;?>', '<?php echo $SHARP_URL;?>', '<?php echo WEBTITLE;?>', '<?php echo WEBDESC;?>' )
</script>
</head>

<body style="background:#fff;">

	<div id="header">
	    <a href="javascript:history.go(-1);" class="header_back"></a>
	    <p class="header_title">绑定手机号</p>
	</div>

	<div class="nr_warp">
		<div class=" bing_warp">
			<div class="bingding_icon">
				<img src="/images/user/binding.png" />
			</div>

			<div class="form_warp">
				<div class="link_btn_warp">
					<a href="?act=user_reg" class="red_btn btn">没有帐号，请先注册</a>
				</div>

				<div class="link_btn_warp" style="margin-bottom:0;">
					<a href="?act=user_bind" class="red_btn btn" style="background:#f8b62b; border:1px solid #f8b62b;" >已有帐号，请登录</a>
				</div>
			</div>
		</div>

		<p class="tip">建议绑定手机号，以便下次快捷登录！</p>
	</div>


	<?php include "footer_web.php";?>
	<?php include "footer_menu_web_tmp.php"; ?>


	<script>
		function tgSubmit(){
			var phone=$("#phone").val();
			if($.trim(phone) == "")
			{
				alert('请输入帐号');
				return false;
			}

			return true;
		}
	</script>

</body>
</html>

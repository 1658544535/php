<!doctype html>
<html lang="zh">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1, user-scalable=no" />
<title><?php echo $site_name;?></title>
<link href="/css/common.css" rel="stylesheet" type="text/css" />
<script src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>
<script type="text/javascript" src="/js/wxshare.js"></script>
<style type="text/css">
	.bing_success_warp{margin-top:80px;}
	.bing_success_warp .bingding_icon img{width:160px;}
	.bind-result{font-family:黑体; font-size:16px;}
	.btn-con{text-align:center; height:auto !important;}
	.red_btn{margin:0 auto; width:70%; display:block; border-radius:8px; font-size:16px;}
</style>
<script>
	wxshare( <?php echo WXJSDEBUG;?>, '<?php echo WXJSAPPID;?>', <?php echo WXJSTIMESTAMP;?>, '<?php echo WXJSNONCESTR;?>', '<?php echo WXJSSIGNATURE;?>', '<?php echo WEBLOGO;?>', '<?php echo $SHARP_URL;?>', '<?php echo WEBTITLE;?>', '<?php echo WEBDESC;?>' )
</script>
</head>

<body style="background:#fff;">
	<div id="header">
	    <a href="javascript:history.go(-1);" class="header_back"></a>
	    <p class="header_title">绑定成功</p>
	</div>

	<div class="nr_warp">
		<div class=" bing_success_warp">
			<div class="bingding_icon">
				<img src="/images/user/binding.png" />
			</div>

			<dl>
				<dd class="bind-result">绑定成功</dd>
				<dd>您可以用微信号或者手机号+密码直接登录</dd>
				<dd class="btn-con">
					<a href="<?php echo empty($_SESSION['loginReferUrl']) ? '/user' : urldecode($_SESSION['loginReferUrl']);?>" class="red_btn">确　定</a>
				</dd>
			</dl>
		</div>
	</div>

	<?php include "footer_web.php";?>

</body>
</html>

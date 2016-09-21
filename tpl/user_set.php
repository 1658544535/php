<!doctype html>
<html lang="zh">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1, user-scalable=no" />
<title>设置</title>
<link href="/css/common.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="/js/jquery-1.11.0.min.js"></script>
<script src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>
<script type="text/javascript" src="/js/wxshare.js"></script>
<script>
	wxshare( <?php echo WXJSDEBUG;?>, '<?php echo WXJSAPPID;?>', <?php echo WXJSTIMESTAMP;?>, '<?php echo WXJSNONCESTR;?>', '<?php echo WXJSSIGNATURE;?>', '<?php echo WEBLOGO;?>', '<?php echo $SHARP_URL;?>', '<?php echo WEBTITLE;?>', '<?php echo WEBDESC;?>' )
</script>

</head>
<body>
<div id="header">
	<a href="javascript:history.back(-1);" class="header_back"></a>
	<p class="header_title">设置</p>
</div>

<div class="user_warp">
	<ul class="user_line_list u_l_l_set">
		<li><a href="/user_info?act=user_set_pwd" class="user_pwd">修改密码</a></li>
		<li><a href="user_about.php" class="user_tzm">关于淘竹马</a></li>
	</ul>

	<?php if ( $user != null ){ ?>
	<div class="user_footer_btn">
		<a href="/user_binding?act=unbind">退出登录</a>
	</div>
	<?php } ?>
</div>
<?php include "footer_web.php";?>
</body>
</html>

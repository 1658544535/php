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
	<a href="/user" class="header_close"></a>
	<p class="header_title">修改密码</p>
</div>

<form action="/user_info?act=user_set_pwd" method="POST" >
	<dl class="user_setPwd">
		<dt class="user_setPwd_1">旧密码</dt>
		<dd><input type="password" name='opwd' placeholder="请输入旧密码" /></dd>
		<dt class="user_setPwd_2">新密码</dt>
		<dd><input type="password" name='npwd' placeholder="请输入新密码" /></dd>
		<dt class="user_setPwd_3">确认密码</dt>
		<dd><input type="password" name='repwd' placeholder="请确认密码" /></dd>
	</dl>

	<div class="user_footer_btn">
		<input type="submit" value="修改密码" />
	</div>
</form>
<?php include "footer_web.php";?>
</body>
</html>

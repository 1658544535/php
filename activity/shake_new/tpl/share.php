<!DOCTYPE html>
<html>
<head>
	<title></title>
	<meta charset="utf-8">
	<script src="<?php echo $site; ?>js/jquery.min.js"></script>
	<script src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>
	<script type="text/javascript" src="/js/wxshare.js"></script>
	<script>
		wxshare( <?php echo WXJSDEBUG;?>, '<?php echo WXJSAPPID;?>', <?php echo WXJSTIMESTAMP;?>, '<?php echo WXJSNONCESTR;?>', '<?php echo WXJSSIGNATURE;?>', '<?php echo WEBLOGO;?>', '<?php echo WEBLINK . "?oid=" . $_SESSION['shake_info']['openid'] . "&unid=" . $_SESSION['shake_info']['unionid'];?>', '<?php echo WEBTITLE;?>', '<?php echo WEBDESC;?>' )
	</script>
</head>
<body>

	<div id="page1" >
		<h1>您的抽奖机会已用完</h1>
		<h3>听说：分享可获抽奖机会哦！！</h3>
	</div>

</body>
</html>
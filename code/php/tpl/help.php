<!doctype html>
<html lang="zh">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1, user-scalable=no" />
<title>客服与帮助</title>
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
	    <a href="javascript:history.go(-1);" class="header_back"></a>
	    <p class="header_title">客服与帮助</p>
	</div>

	<div class="help_list big">
		<ul>
			<li><a href="/help?act=list&pid=1">
				<img src="/images/help/icon_1.png" />
				<div class="help_list_main">
					<h3>常见问题</h3>
					<p>各种常见问题，帮助你迅速了解淘竹马</p>
				</div>
			</a></li>
			<li><a href="/help?act=list&pid=2">
				<img src="/images/help/icon_2.png" />
				<div class="help_list_main">
					<h3>售前问题</h3>
					<p>优惠活动、选购商品、注册登录、支付方式等</p>
				</div>
			</a></li>
			<li><a href="/help?act=list&pid=3">
				<img src="/images/help/icon_3.png" />
				<div class="help_list_main">
					<h3>售后问题</h3>
					<p>订单修改、物流查询、售后服务、退款操作等</p>
				</div>
			</a></li>
			<li><a href="/feedback.php">
				<img src="/images/help/icon_4.png" />
				<div class="help_list_main">
					<h3>投诉建议</h3>
					<p>意见与建议，维权与投诉等</p>
				</div>
			</a></li>
		</ul>
		<div class="help_tel">
			<img src="/images/help/icon_5.png" />
			<span>客服电话：400-150-3677</span>
		</div>
	</div>

	<?php include "footer_web.php";?>

</body>
</html>

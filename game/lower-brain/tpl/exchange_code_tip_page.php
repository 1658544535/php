<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="zh-CN">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=100%; initial-scale=1; maximum-scale=1; minimum-scale=1; user-scalable=no;" />
<meta content="telephone=no" name="format-detection" />
<title><?php echo $site_name;?></title>
<link href="<?php echo $site_game; ?>/css/www.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="<?php echo $site_game; ?>/js/jquery.min.js"></script>
<script src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>
<script type="text/javascript" src="<?php echo $site_game; ?>/js/wxshare.js"></script>
<script>
	wxshare( <?php echo WXJSDEBUG;?>, '<?php echo WXJSAPPID;?>', <?php echo WXJSTIMESTAMP;?>, '<?php echo WXJSNONCESTR;?>', '<?php echo WXJSSIGNATURE;?>', '<?php echo WEBLOGO;?>', '<?php echo WEBLINK;?>', '<?php echo WEBTITLE;?>', '<?php echo WEBDESC;?>' )
</script>


</head>

<body>
	<div class="code_warp2">
		<img src="<?php echo $site_game; ?>/images/bg2.png" id="bg_img" />

		<div id="top">
			<a onclick="history.go(-1)">
				<img src="<?php echo $site_game; ?>/images/back_btn.png" id="back_btn" />
			</a>
		</div>

		<h1 id="title">如何获得兑换码</h1>

		<dl id="code_tip">
			<dt>方式一</dt>
			<dd style="text-align:center;">
				<img src="<?php echo $site_game; ?>/images/qrcode.png" width="100px" />
			</dd>
			<dd style="text-align:center;">长按二维码，关注“淘竹马”</dd>

			<dt>方式二</dt>
			<dd>1、微信搜“淘竹马”公众号，关注微信号</dd>
			<dd>2、点击“我的淘竹马”</dd>
			<dd>3、查看兑换码</dd>
		</dl>

	</div>
</body>
</html>

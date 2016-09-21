
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="zh-CN">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta charset="utf-8" name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" />
<meta name="format-detection" content="telephone=no" />
<title><?php echo $site_name;?></title>
<link href="/css/common.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="/js/jquery-1.8.3.min.js"></script>
<script src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>
<script type="text/javascript" src="/js/wxshare.js"></script>
<script>
	wxshare( <?php echo WXJSDEBUG;?>, '<?php echo WXJSAPPID;?>', <?php echo WXJSTIMESTAMP;?>, '<?php echo WXJSNONCESTR;?>', '<?php echo WXJSSIGNATURE;?>', '<?php echo WEBLOGO;?>', '<?php echo $SHARP_URL;?>', '<?php echo WEBTITLE;?>', '<?php echo WEBDESC;?>' )
</script>

</head>

<body>

	<div id="header">
		<dl id="title_warp">
			<dd>
				<a href="<?php echo $return_url; ?>">
					<img src="/images/index/icon-back.png" />
				</a>
			</dd>
			<dd>申请分销</dd>
			<dd><!--<img src="/images/index/icon-back.png" />--></dd>
		</dl>
	</div>

	<div class="nr_warp">
		<div class="order_empty" >
			<dl>
				<dd><img src="/images/user_distribution/<?php echo $status_info[$rs->status]['icon']; ?>.png" width="100" /></dd>
				<dd><?php echo $status_info[$rs->status]['desc']; ?></dd>
			</dl>
		</div>
	</div>


<?php include "footer_web.php"; ?>

<?php include "footer_menu_web_tmp.php"; ?>
</body>
</html>

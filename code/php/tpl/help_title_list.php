<!doctype html>
<html lang="zh">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1, user-scalable=no" />
<title>常见问题</title>
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
	    <p class="header_title">常见问题</p>
	</div>

	<div class="help_list small">
		<ul>
			<?php foreach ( $rs as $info ){ ?>
				<li><a href="/help?act=content&pid=<?php echo $info->id ?>">
					<img src="/images/help/icon_6.png" />
					<div class="help_list_main">
						<?php
							mb_internal_encoding('utf8');//以utf8编码的页面为例
							$title = (mb_strlen($info->title)>18) ? mb_substr($info->title,0,18).'...' : $info->title;
						?>
						<h3><?php echo $title ?></h3>
					</div>
				</a></li>
			<?php } ?>
		</ul>
	</div>

	<?php include "footer_web.php";?>

</body>
</html>

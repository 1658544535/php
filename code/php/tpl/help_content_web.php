<!doctype html>
<html lang="zh">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1, user-scalable=no" />
<title><?php echo $site_name;?></title>

<link href="/css/common.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="/js/jquery-1.11.0.min.js"></script>
<script src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>
<script type="text/javascript" src="/js/wxshare.js"></script>
<script>
	wxshare( <?php echo WXJSDEBUG;?>, '<?php echo WXJSAPPID;?>', <?php echo WXJSTIMESTAMP;?>, '<?php echo WXJSNONCESTR;?>', '<?php echo WXJSSIGNATURE;?>', '<?php echo WEBLOGO;?>', '<?php echo $SHARP_URL;?>', '<?php echo WEBTITLE;?>', '<?php echo WEBDESC;?>' )
</script>
</head>

<body style="background:#fff;">
	<div id="header">
	    <a href="javascript:history.go(-1);" class="header_back"></a>
	    <p class="header_title"><?php echo $row->title?></p>
	</div>

	<div style="padding:10px;">
		<?php
    		$content = str_replace( "font-size: 16px;", "font-size: 12px; line-height:22px;", $row->content);								// 更新链接
    		echo $content;
    	?>
	</div>
	<?php include "footer_web.php";?>

</body>
</html>

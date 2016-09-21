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

<style>
	*{ margin:0px; padding:0px; }
	.index_warp{ width:600px; height:800px; border:1px solid #ccc; margin:20px auto;  }
</style>

</head>

<body>
	<div class="tip_warp">
		<img src="<?php echo $site_game; ?>/images/battle_bg.png" id="bg_img" />
		<div id='btn_warp' >
			<a href="<?php echo $site_game; ?>/problem.php">
				<img src="<?php echo $site_game; ?>/images/play_btn.png" id="btn" />
			</a>
		</div>
	</div>
</body>
</html>

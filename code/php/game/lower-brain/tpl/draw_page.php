<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="zh-CN">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=100%; initial-scale=1; maximum-scale=1; minimum-scale=1; user-scalable=no;" />
<meta content="telephone=no" name="format-detection" />
<title><?php echo $site_name;?></title>
<script type="text/javascript" src="<?php echo $site_game; ?>/js/jquery.min.js"></script>
<script src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>
<script type="text/javascript" src="<?php echo $site_game; ?>/js/wxshare.js"></script>

<script>
	wxshare( <?php echo WXJSDEBUG;?>, '<?php echo WXJSAPPID;?>', <?php echo WXJSTIMESTAMP;?>, '<?php echo WXJSNONCESTR;?>', '<?php echo WXJSSIGNATURE;?>', '<?php echo WEBLOGO;?>', '<?php echo WEBLINK;?>', '<?php echo WEBTITLE;?>', '<?php echo WEBDESC;?>' )
</script>


<style>
	*{ margin:0px; padding:0px; }
	body{ background:#d6a770; font-family:'Microsoft YaHei'; }
	a{ text-decoration:none; }

	@media ( min-width: 380px ) {
		.tip_warp{ min-width:320px;  max-width:580px;  margin:0px auto; position:relative; }
		.tip_warp #bg_img{ margin: 0 auto; width:100%; height:900px;  }
		.tip_warp #code_tip_warp img { position:absolute; top:6%; width:20%; right:3%; }
		.tip_warp #btn_warp img{position:absolute; bottom:5%; left:30%; width:40%;}
		.tip_warp .btn_left {  position:absolute; top:80%; left:10%;  width:38%;  }
		.tip_warp .btn_right {  position:absolute; top:80%; right:8%;  width:38%;  }
	}

	@media ( max-width: 380px ) {
		.tip_warp{ min-width:320px;  max-width:580px; min-height:400px; margin:0px auto; position:relative; }
		.tip_warp #bg_img{ margin: 0 auto; width:100%; height:500px;  }
		.tip_warp #code_tip_warp img { position:absolute; top:6%; width:25%; right:3%; }
		.tip_warp #btn_warp img{position:absolute; bottom:5%; left:30%; width:40%;}
		.tip_warp .btn_left {  position:absolute; top:80%; left:10%;  width:35%;  }
		.tip_warp .btn_right {  position:absolute; top:80%; right:8%;  width:35%;  }
	}


 #bg,#bg2 {
		display: none;
		position: fixed;
		top: 0%;
		left: 0%;
		width: 100%;
		height: 100%;
		background: url(<?php echo $site_game; ?>/images/guide_bg.png);
		z-index: 1001;
		/*  -moz-opacity: 0.7;  opacity:.70;  filter: alpha(opacity=70);*/
	}
</style>

</head>

<body>
	<div class="tip_warp">
		<img src="<?php echo $site_game; ?>/images/draw_bg.png" id="bg_img" />

		<div id="code_tip_warp">
			<a href="/game/lower-brain/page.php?type=exchange_code_tip">
				<img src="<?php echo $site_game; ?>/images/code_tip.png" />
			</a>
		</div>

		<a href="/game/lower-brain">
			<img src="<?php echo $site_game; ?>/images/goon_btn2.png" class="btn_left" />
		</a>

		<a href="/game/lower-brain/page.php?type=rank">
			<img src="<?php echo $site_game; ?>/images/rank_btn.png" class="btn_right" />
		</a>

	</div>
</body>
</html>

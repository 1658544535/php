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

	function showFriendDIv(){
		document.getElementById('bg2').style.display = "block";
	}

	function hideFriendDIv(){
		document.getElementById('bg2').style.display = "none";
	}
</script>

<style>
	*{ margin:0px; padding:0px; }
	body{ background:#d6a770; font-family:'Microsoft YaHei'; }
	a{ text-decoration:none; }

	@media ( min-width: 380px ) {
		/*===============  单机成功页面  ==================*/
		.share_warp{ min-width:320px;  max-width:580px;  margin:0px auto; position:relative; }
		.share_warp #bg_img{ margin: 0 auto; width:100%; height:680px; }

		/*===============  单机成功页面  ==================*/
		.share_warp #code_tip_warp img { position:absolute; top:20%; width:20%; right:4%; }
		.share_warp #tip_warp img{ width:38%; position:absolute; top:28%; left:34%; }
		.share_warp #tip_warp .tip_txt a{ position:absolute; top:36%; left:24%; font-size:14px; text-decoration:none; color:#6a3906; font-weight:bold; }
		.share_warp #score_tip{ font-size:42px; position:absolute; top:53%; left:12%; color:#6a3906; }
		.share_warp #score_warp #score_txt { position:absolute; left:49%; top:55%; z-index:999; font-size:60px; color:#fff; width:100px; text-align:center; }
		.share_warp #score_warp img{ position:absolute; top:45%; left:28%; width:52%; }
		.share_warp .btn_left {  position:absolute; top:85%; left:10%;  width:28%;  }
		.share_warp .btn_right {  position:absolute; top:85%; right:8%;  width:28%;  }
		.share_warp #goon_warp { position:absolute; top:85%; left:30%; }
		.share_warp #goon_warp .btn{ width:60%; }
	}

	@media ( max-width: 380px ) {
		/*===============  单机成功页面  ==================*/
		.share_warp{ min-width:320px;  max-width:580px; min-height:400px; margin:0px auto; position:relative; }
		.share_warp #bg_img{ margin: 0 auto; width:100%; height:500px;  }

		/*===============  单机成功页面  ==================*/
		.share_warp #code_tip_warp img { position:absolute; top:20%; width:25%; right:3%; }

		.share_warp #tip_warp img{ width:40%; position:absolute; top:28%; left:32%; }
		.share_warp #tip_warp .tip_txt a{ position:absolute; top:28%; left:30%; font-size:14px; text-decoration:none; color:#6a3906; font-weight:bold; }
		.share_warp #score_tip{ font-size:30px; position:absolute; top:48%; left:12%; color:#6a3906; }

		.share_warp #score_warp #score_txt { position:absolute; left:45%; top:58%; z-index:999; font-size:60px; color:#fff; width:100px; text-align:center; }
		.share_warp #score_warp img{ position:absolute; top:43%; left:22%; width:60%; }

		.share_warp .btn_left {  position:absolute; top:80%; left:8%;  width:38%;  }
		.share_warp .btn_right {  position:absolute; top:80%; right:8%;  width:38%;  }
		.share_warp #goon_warp { position:absolute; top:90%; left:30%; }
		.share_warp #goon_warp .btn{ width:60%; }
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
	<div class="share_warp">
		<img src="<?php echo $site_game; ?>/images/bg3.png" id="bg_img" />

		<div id="code_tip_warp">
			<a href="/game/lower-brain/page.php?type=exchange_code_tip">
				<img src="<?php echo $site_game; ?>/images/code_tip.png" />
			</a>
		</div>

		<div id="tip_warp">
			<a href="javascript:showFriendDIv();">
				<img src="<?php echo $site_game; ?>/images/share.png" />
			</a>
		</div>

		<div id="score_warp">
			<span id="score_txt"><?php echo $_GET['score']; ?></span>
			<img src="<?php echo $site_game; ?>/images/score_bg.png" />
		</div>


		<a href="/game/lower-brain">
			<img src="<?php echo $site_game; ?>/images/goon_btn2.png" class="btn_left" />
		</a>

		<a href="/game/lower-brain/page.php?type=rank">
			<img src="<?php echo $site_game; ?>/images/rank_btn.png" class="btn_right" />
		</a>
<!--
		<a href="/game/lower-brain/page.php?type=exchange_code">查看兑换码</a></br>
		<a href="/game/lower-brain/page.php?type=battle_index">查看我的战绩</a></br>
		<a href="/game/lower-brain/page.php?type=rank">查看排名</a></br>
-->
	</div>

	<div id="bg2" onclick="hideFriendDIv();" style="display: none;">
		<img src="images/guide_firend.png" alt="" style="position: fixed; top: 0; right: 16px;">
	</div>
</body>
</html>


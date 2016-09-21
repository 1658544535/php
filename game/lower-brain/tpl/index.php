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
<link href="<?php echo $site_game; ?>/css/www.css" rel="stylesheet" type="text/css" />

<script>
	wxshare( <?php echo WXJSDEBUG;?>, '<?php echo WXJSAPPID;?>', <?php echo WXJSTIMESTAMP;?>, '<?php echo WXJSNONCESTR;?>', '<?php echo WXJSSIGNATURE;?>', '<?php echo WEBLOGO;?>', '<?php echo WEBLINK;?>', '<?php echo WEBTITLE;?>', '<?php echo WEBDESC;?>' )
</script>

</head>

<body>
	<div class="index_warp">

		<div id="code_tip_warp">
			<a href="/game/lower-brain/page.php?type=rank">
				<img src="<?php echo $site_game; ?>/images/rank_tip.png"  id="rank" />
			</a>
			<a href="/game/lower-brain/page.php?type=rule">
				<img src="<?php echo $site_game; ?>/images/game_rule.png" id="rule" />
			</a>
		</div>


		<div id='logo'>
			<img src="<?php echo $site_game; ?>/images/logo.png" />
		</div>

		<div id="watch_warp">
			<a href="<?php echo $site_game; ?>/page.php?type=rule">
				<img src="<?php echo $site_game; ?>/images/watch.png" />
			</a>
		</div>

		<div id='btn_warp' >
			<a href="<?php echo $site_game; ?>/problem.php">
				<img src="<?php echo $site_game; ?>/images/play_btn.png" id="btn" />
			</a>
		</div>

<!--
		<div>
			<a href="/game/lower-brain/problem.php">开始游戏</a></br>
			<a href="/game/lower-brain/page.php?type=exchange_code">查看兑换码</a></br>
			<a href="/game/lower-brain/page.php?type=battle_index">查看我的战绩</a></br>
			<a href="/game/lower-brain/page.php?type=rank">查看排名</a></br>
		</div>
-->
	</div>

</body>
</html>

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
		<div class="battle_warp">
			<img src="<?php echo $site_game; ?>/images/bg2.png" id="bg_img" />

			<div id="top">
				<a href="<?php echo $site_game; ?>">
					<img src="<?php echo $site_game; ?>/images/back_btn.png" id="back_btn" />
				</a>
			</div>

			<div id="battle_title">
				<h3>我的战绩</h3>
			</div>

			<div id="battle_result">
				<dl class="result_warp">
					<dd><img src="<?php echo $site_game; ?>/images/win_btn.png" /></dd>
					<dd class="txt"><?php echo $BattleResult->winNum; ?></dd>
					<dd><img src="<?php echo $site_game; ?>/images/lose_btn.png"  /></dd>
					<dd class="txt"><?php echo $BattleResult->loseNum; ?></dd>
				</dl>
			</div>

			<div id="battle_list">
				<?php foreach( $BattleList as $results ){ ?>
					<p>
						<?php echo date( 'm-d',$results->time ) ?>　
						<?php echo $results->sponsor_name ?>：<?php echo $results->sponsor_scroe ?>　
						<?php echo $results->challenger_name ?>：<?php echo $results->challenger_score ?>
					</p>
				<?php } ?>
			</div>

		</div>
	</body>
</html>

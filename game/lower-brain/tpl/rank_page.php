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
		<div class="rank_warp">
			<img src="<?php echo $site_game; ?>/images/bg2.png" id="bg_img" />

			<div id="top">
				<a onclick="history.go(-1)">
					<img src="<?php echo $site_game; ?>/images/back_btn.png" id="back_btn" />
				</a>
				<div class="clear"></div>
			</div>

			<div id='tip'>
				<img src="<?php echo $site_game; ?>/images/rank.png" />
			</div>

			<dl id="rank_list">
				<?php foreach( $arrRankList as $key=>$rank) { ?>
					<dd>
						<img src="<?php echo $rank->img; ?>" width='30' />
						<p class="u_name"><?php echo $rank->name; ?></p>
						<p class="u_score"><?php echo $rank->score; ?></p>
					</dd>
				<?php } ?>
			</dl>

			<div id="rank_mine">
				<?php if ( $getMyRank == null ){ ?>
					<p>您还暂未参与过游戏！</p>
				<?php }else{ ?>
					<p>您当前的为第 <?php echo $getMyRank ?> 名</p>
				<?php } ?>
			</div>

		</div>
	</body>
</html>

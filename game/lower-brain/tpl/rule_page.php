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
		<div class="rule_warp">
			<img src="<?php echo $site_game; ?>/images/bg2.png" id="bg_img" />

			<div id="top">
				<a href="<?php echo $site_game; ?>">
					<img src="<?php echo $site_game; ?>/images/back_btn.png" id="back_btn" />
				</a>
			</div>

			<div id="rank_txt">
				<h1>游戏规则：如何获得更多兑换码</h1>
				<p>1.首玩游戏通关达到 <?php echo GAME_SUCCESS_SCROE; ?> 分可获得一个兑换码，<?php echo GAME_ERROR_NUM; ?> 道错题游戏结束。</p>
				<p>2.分享给你的朋友们，通过你的分享去玩，分数比你高者兑换码由你朋友获得，分数比你低者兑换码由你获得。</p>
				<p>提示：获取的兑换码越多中奖几率越大哦！</p>

				<p style="margin-top:5px;">通关之后将获得一个兑换码，兑换日分别为6月21号和7月22号，兑换号为当天双色球串联码后5位数含蓝色球号，如兑换码与兑换号一致的话，恭喜你，可以获取一只Apple watch啦！</p>
				</br>
				<p style="text-align:center;">本游戏最终解释权归群宇互动科技所有</p>
			</div>

		</div>
	</body>
</html>

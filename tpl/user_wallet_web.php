<!doctype html>
<html lang="zh">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1, user-scalable=no" />
<title>我的钱包</title>
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
	<a href="javascript:history.back(-1);" class="header_back"></a>
	<p class="header_title">我的钱包</p>
</div>
<div class="wallet_money">
	<h3>我的钱包月(元)</h3>
	<p><?php echo sprintf('%.2f', $objUserWalletInfo->balance); ?></p>
</div>

<div class="wallet_list">
	<ul>
		<li>
			<div class="left">记录</div>
			<div class="right">余额明细</div>
		</li>

		<?php if( $objUserWalletLogList != NULL ){ ?>
			<?php foreach( $objUserWalletLogList as $UserWalletLog ){ ?>
				<li>
					<div class="left">
						<h3>我</h3>
						<p><?php echo $UserWalletLog->remarks; ?></p>
					</div>
					<div class="right">
						<span><?php echo $UserWalletLog->create_date; ?></span>
						<p>
							<?php echo $UserWalletLog->type == 0 ? '获得' : '扣除'; ?>
							<?php echo $UserWalletLog->trade_amt; ?>元
						</p>
					</div>
				</li>
			<?php } ?>
		<?php } ?>
	</ul>
</div>

<?php include "footer_web.php";?>
<script>
	$(function(){
		$(window).scroll(function(event) {
			var tabTop = $(".wallet_list").offset().top;
			$(window).scrollTop()>tabTop ? $(".wallet_list ul li:eq(0)").addClass("active") : $(".wallet_list ul li:eq(0)").removeClass("active");
		});
	});
</script>
</body>
</html>

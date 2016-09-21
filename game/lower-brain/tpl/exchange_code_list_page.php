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
	<div class="code_warp">

		<div id="code_tip_warp">
			<a href="/game/lower-brain">
				<img src="<?php echo $site_game; ?>/images/goon_game3.png" />
			</a>
		</div>

		<h1>我的兑换码</h1>

		<p class="code_tip">兑换日分别为6月21号和7月22号，兑换号为当天双色球串联码后5位数含蓝色球号，如兑换码与兑换号一致的话，恭喜你，可以获取一只Apple watch啦</p>

		<table>
			<tr>
				<td width="30%"><strong>兑奖码</strong></td>
				<td width="35%"><strong>获得方式</strong></td>
				<td width="18%"><strong>时间</strong></td>
			</tr>

			<?php foreach( $arrExchangeCodeList as $results ){ ?>
				<tr>
					<td height='35' width='110'><?php echo $results->value ?></td>
					<td width="150" ><?php echo ( $results->from == 1 ) ? '关注获取兑换码' : 'PK对战获得' ?></td>
					<td width='80'><?php echo date( 'm-d', $results->time ) ?></td>
				</tr>
			<?php } ?>
		</table>
	</div>
</body>
</html>

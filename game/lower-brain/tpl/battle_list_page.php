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
	.index_warp{ width:600px; height:800px; border:1px solid #ccc; margin:20px auto;  }
</style>

</head>

<body>
	<div class="index_warp">
		<h1>战绩列表</h1>

		<table>
			<tr>
				<td>挑战者</td>
				<td>应战者</td>
				<td>结果</td>
			</tr>

			<?php foreach( $arrExchangeCodeList as $results ){ ?>
				<tr>
					<td><img src="<?php echo $results->sponsor_img; ?>" width='40' /><?php echo $results->sponsor_name ?></td>
					<td><img src="<?php echo $results->challenger_img; ?>" width='40' /><?php echo $results->challenger_name ?></td>
					<td>
						<?php
							switch ($results->result)
							{
								case 1:
									$result =  "挑战者胜";
								break;

								case 0:
									$result =  "战平";
								break;

								case -1:
									$result =  "应战者胜";
								break;
							}

							$result .= '(' . $results->sponsor_scroe  . ':' . $results->challenger_score  . ')';

							echo $result;
						?>

					</td>
				</tr>
			<?php } ?>
		</table>
	</div>
</body>
</html>

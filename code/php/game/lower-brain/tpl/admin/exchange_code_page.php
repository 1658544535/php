<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head runat="server">
	    <title>管理后台</title>
		<link href="/game/lower-brain/css/admin.css" rel="stylesheet" type="text/css" />
	    <style>

	    </style>

	</head>

	<body>
		<div class="data_warp" >
			<dl class="beak">
				<dd>当前位置：</dd>
				<dd><a href="<?php echo $site_game_bg ?>/">后台首页</a></dd>
				<dd> > 兑换码库</dd>
				<div class="clear"></div>
			</dl>

	    	<p>
	    		兑换码库信息
	    	</p>
			<table width="400" border="0" cellspacing="0" cellpadding="0">
				<thead>
					<tr>
						<td>兑换码总数</td>
						<td>未兑换数</td>
						<td>已兑换数</td>
					</tr>
				</thead>

				<tbody>
					<tr>
						<td><?php echo $valid + $novalid; ?></td>
						<td><?php echo $valid; ?></td>
						<td><?php echo $novalid; ?></td>
					</tr>
				</tbody>
			</table>

		</div>
	</body>
</html>

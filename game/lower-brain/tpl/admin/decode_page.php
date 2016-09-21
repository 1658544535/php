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
				<dd> > 加密工具 </dd>
				<div class="clear"></div>
			</dl>

		    <form>
		    	<input type="hidden" name="act" value="decode" />

				<dl>
					<h4>加密工具</h4>
					<dd>
						<dt>加密前</dt>
						<input class="input_txt" type="text" name="val" value="<?php echo $encrypt; ?>" />
					<dd>

					<dd>
						<dt>加密后</dt>
						<input class="input_txt" type="text" readonly value="<?php echo $res; ?>" />
					<dd>
				</dl>

				<dd>
					<input type="submit" name="提交" class="btn" />
				<dd>
		    </form>

		</div>
	</body>
</html>

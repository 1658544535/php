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

		    <form id="form1" action="<?php echo $site_game_bg ?>/login.php" method="post">
		    	<input type="hidden" name="act" value="login_save" />
		    	<p>最贱大脑后台登录</p>

				<dl>
					<dd>
						<dt>用户名</dt>
						<input class="input_txt" type="text" name="user_name" />
					<dd>

					<dd>
						<dt>密码</dt>
						<input class="input_txt" type="password" name="pwd" />
					<dd>

				</dl>


				<dd>
					<input type="submit" name="提交" class="btn" />
				<dd>

		    </form>
		</div>
	</body>
</html>

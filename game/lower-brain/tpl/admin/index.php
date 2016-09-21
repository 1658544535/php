<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head runat="server">
	    <title>管理后台</title>
		<link href="/game/lower-brain/css/admin.css" rel="stylesheet" type="text/css" />
	</head>

	<body>
	    <form id="form1" action="manage_save.php" class="data_warp" method="post">
	    	<input type="hidden" name="act" value="dummy" />

	    	<p>
	    		最贱大脑后台管理系统
	    		<a href="/game/lower-brain/admin_bg/login.php?act=loginout" > 【退出登录】 </a>
	    	</p>
			<ul>
				<a href="<?php echo $site_game_bg ?>/setting.php"><li> 游戏设置 </li></a>
				<a href="<?php echo $site_game_bg ?>/question.php"><li> 游戏题库 </li></a>
				<a href="<?php echo $site_game_bg ?>/exchange_code.php"><li> 兑换码库 </li></a>
				<a href="<?php echo $site_game_bg ?>/"><li> 游戏说明 </li></a>
				<div class="clear"></div>
			</ul>

			</br></br>
			<p>调试工具</p>
			<ul>
				<a href="<?php echo $site_game_bg ?>/tool.php?act=decode"><li> 加密工具 </li></a>
				<a href="<?php echo $site_game_bg ?>/tool.php?act=encode"><li> 解密工具 </li></a>
				<div class="clear"></div>
			</ul>

	    </form>

	</body>
</html>

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
				<dd> > 最贱大脑游戏参数设置</dd>
				<div class="clear"></div>
			</dl>

		    <form id="form1" action="<?php echo $site_game_bg ?>/setting.php" method="post">
		    	<input type="hidden" name="act" value="edit" />
		    	<p>最贱大脑游戏参数设置</p>

				<dl>
					<dd>
						<dt>是否启动</dt>
						<select name="enable" class="input_txt">
							<option value="1" <?php echo $selected =  ($objData->enable  == 1 ) ? 'selected' : ''; ?> >开启</option>
							<option value="0" <?php echo $selected =  ($objData->enable  == 0 ) ? 'selected' : ''; ?> >不开启</option>
						</select>
					<dd>
				</dl>

				<dl>
					<h4>设置参数</h4>
					<dd>
						<dt>允许错误数</dt>
						<input class="input_txt" type="text" name="error_num" value="<?php echo $objData->error_num; ?>" />
					<dd>

					<dd>
						<dt>通关数</dt>
						<input class="input_txt" type="text" name="success_score" value="<?php echo $objData->success_scroe; ?>" />
					<dd>

					<dd>
						<dt>同个PK场次允许比较的相隔时间(单位：秒)</dt>
						<input class="input_txt" type="text" name="math_game_time" value="<?php echo $objData->math_game_time; ?>" />
					<dd>
				</dl>

				<dl>
					<h4>兑换码发放批次</h4>
					<dd>
						<dt>发放兑换码批次(由于一次性发放数据库读取不过来，所以要按批次发放，每批1000个)</dt>
						<input class="input_txt" type="text" name="code_num" value="<?php echo $objData->code_num; ?>" />
					<dd>

				</dl>


				<dd>
					<input type="submit" name="提交" class="btn" />
				<dd>

		    </form>
		</div>
	</body>
</html>

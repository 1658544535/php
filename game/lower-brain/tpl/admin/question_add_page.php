<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head runat="server">
	    <title>管理后台</title>
		<link href="/game/lower-brain/css/admin.css" rel="stylesheet" type="text/css" />
		<script src="/game/lower-brain/js/jquery.min.js"></script>
	</head>

	<body>
		<div class="data_warp" >
			<dl class="beak">
				<dd>当前位置：</dd>
				<dd><a href="<?php echo $site_game_bg ?>/">后台首页</a></dd>
				<dd> > <a href="<?php echo $site_game_bg ?>/question.php">游戏题库</a></dd>
				<dd> > 添加题目</dd>
				<div class="clear"></div>
			</dl>

	    	<form id="form1" action="<?php echo $site_game_bg ?>//question.php" method="post">
		    	<input type="hidden" name="act" value="add_save" />
		    	<p>添加题目</p>

				<dl>
					<dd>
						<dt>题目类型</dt>
						<select name="type" class="input_txt" id="type">
							<option value="1">选择题</option>
							<option value="2">判断题</option>
						</select>
					<dd>

					<dd>
						<dt>题目</dt>
						<input class="input_txt" type="text" name="question" />
					<dd>

					<dd>
						<dt>正确答案 (此处添加题目的正确答案)</dt>
						<input class="input_txt" type="text" name="answer_r" />
					<dd>
					<dt>其他答案</dt>
					<dd>
						<input class="input_txt" type="text" name="answer_w[]" />
					<dd>

					<dd class="iftype">
						<input class="input_txt" type="text" name="answer_w[]" />
					<dd>

					<dd class="iftype">
						<input class="input_txt" type="text" name="answer_w[]" />
					<dd>
				</dl>


				<dd>
					<input type="submit" name="提交" class="btn" />
				<dd>

		    </form>

		</div>
	</body>
</html>

<script>
	$(function(){
		$('#type').change(function(){
			if( $(this).val() == 2 )
			{
				$('.iftype').hide();
			}
			else
			{
				$('.iftype').show();
			}
		})
	})
</script>

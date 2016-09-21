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
				<dd> > <a href="<?php echo $site_game_bg ?>/question.php">游戏题库</a></dd>
				<dd> > 更新题目</dd>
				<div class="clear"></div>
			</dl>

	    	<form id="form1" action="<?php echo $site_game_bg ?>/question.php" method="post">
		    	<input type="hidden" name="act" value="edit_save" />
		    	<p>更新题目</p>

				<dl>
					<dd>
						<dt>题目</dt>
						<input class="input_txt" type="text" name="question" value="<?php echo $question_info->question; ?>" />
						<input class="input_txt" type="hidden" name="question_id" value="<?php echo $question_info->id; ?>" />
					<dd>
				</dl>

				<dl>
					<dd>
						<dt>正确答案</dt>
						<?php foreach( $answer_right_list as $answer_right ){ ?>
							<input class="input_txt" type="text" name="answer[<?php echo $answer_right->id; ?>]" value="<?php echo $answer_right->text; ?>" />
						<?php } ?>
					<dd>

					<?php if ( $question_info->type == 1 ){ ?>
						<dt>其他选项</dt>
						<dd>
							<input class="input_txt" type="text" name="answer[<?php echo $answer_wrong_list[0]->id; ?>]" value="<?php echo $answer_wrong_list[0]->text; ?>" />
						<dd>

						<dd>
							<input class="input_txt" type="text" name="answer[<?php echo $answer_wrong_list[1]->id; ?>]" value="<?php echo $answer_wrong_list[1]->text; ?>" />
						<dd>

						<dd>
							<input class="input_txt" type="text" name="answer[<?php echo $answer_wrong_list[2]->id; ?>]" value="<?php echo $answer_wrong_list[2]->text; ?>" />
						<dd>
					<?php }else{ ?>
						<dt>其他选项</dt>
						<dd>
							<input class="input_txt" type="text" name="answer[<?php echo $answer_wrong_list[0]->id; ?>]" value="<?php echo $answer_wrong_list[0]->text; ?>" />
						<dd>
					<?php } ?>
				</dl>


				<dd>
					<input type="submit" name="提交" class="btn" />
				<dd>

		    </form>

		</div>
	</body>
</html>

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
				<dd> > 游戏题库</dd>
				<div class="clear"></div>
			</dl>

	    	<p>
	    		游戏题库<a id='add' href="<?php echo $site_game_bg ?>/question.php?act=add" >【 添加题目 】</a>
	    	</p>

			<table width="400" border="0" cellspacing="0" cellpadding="0">
				<thead>
					<tr>
						<td width="100">编号</td>
						<td>题目</td>
						<td width="100">类型</td>
						<td>答案</td>
						<td width="100">操作</td>
					</tr>
				</thead>

				<tbody>
					<?php foreach( $question_list as $question ){ ?>
					<tr>
						<td><?php echo $question->id; ?></td>
						<td><?php echo $question->question; ?></td>
						<td><?php echo ($question->type == 1) ? '选择题' : '判断题' ; ?></td>
						<td>
							<?php foreach( $question->answer as $answer ){ ?>
								<span style="font-size:14px; line-height:20px;"><?php echo $answer->text; ?></span></br>
							<?php } ?>
						</td>
						<td>
							<a href="<?php echo $site_game_bg ?>/question.php?act=edit&id=<?php echo $question->id; ?>">编辑</a>
						</td>
					</tr>
					<?php } ?>
				</tbody>
			</table>

		</div>
	</body>
</html>

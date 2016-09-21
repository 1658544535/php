<!DOCTYPE html>
<html>
<head>
	<title></title>
	<meta charset="utf-8">
	<meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, minimal-ui, user-scalable=0" name="viewport">
	<style>
		*{ margin:0px; padding:0px;}
		body{ font-family: 'Microsoft YaHei'; background:#8DE2F6; }
		.clear{ clear:both; }
		h4{ margin:5px; text-align:center; }
		dl{ width:100%; margin:0 auto; }
		dl a{ color:#FDFDFF; text-decoration:none; display:inline-block; }
		dl dd.game{ text-align:center; height:150px; line-height:150px; width: 42%;  margin:8px; background:#22A5C3; float:left; }
		dl dd.close{ text-align:center; height:45px; line-height:45px; widht:60%; margin:10px 10px 5px; background:#F9746F; }
	</style>
</head>

<body>
	<h4>当前进行中的活动：<?php echo $rs==null ? '无' :$rs->title; ?></h4>
	<dl>
		<dd class="game">
			<a href="<?php $site ?>option.php?act=option_save&aid=35">开启活动一</a>
		</dd>

		<dd class="game">
			<a href="<?php $site ?>option.php?act=option_save&aid=36">开启活动二</a>
		</dd>

		<dd class="game">
			<a href="<?php $site ?>option.php?act=option_save&aid=38">开启活动三</a>
		</dd>

		<dd class="game">
			<a href="<?php $site ?>option.php?act=option_save&aid=37">开启活动四</a>
		</dd>

		<div class="clear"></div>

		<dd class='close'>
			<a href="<?php $site ?>option.php?act=option_save&aid=0">关闭全部活动</a>
		</dd>
	</dl>
</body>
</html>
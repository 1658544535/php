<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="zh-CN">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=100%; initial-scale=1; maximum-scale=1; minimum-scale=1; user-scalable=no;" />
<meta content="telephone=no" name="format-detection" />
<title><?php echo $site_name;?></title>
<link href="<?php echo $site_game; ?>/css/www.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="<?php echo $site_game; ?>/js/jquery.min.js"></script>
<script src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>
<script type="text/javascript" src="<?php echo $site_game; ?>/js/wxshare.js"></script>
<script>
	wxshare( <?php echo WXJSDEBUG;?>, '<?php echo WXJSAPPID;?>', <?php echo WXJSTIMESTAMP;?>, '<?php echo WXJSNONCESTR;?>', '<?php echo WXJSSIGNATURE;?>', '<?php echo WEBLOGO;?>', '<?php echo WEBLINK;?>', '<?php echo WEBTITLE;?>', '<?php echo WEBDESC;?>' )
</script>

<style>
	*{ margin:0px; padding:0px; }
</style>

</head>

<body>
	<div class="question_warp">
		<img src="<?php echo $site_game; ?>/images/bg3.png" id="bg_img" />
		<div id="tip_warp">
			<div class="wrong_btn">
				<div class="wrong_txt"><?php echo sprintf('%d',$errorCount); // sprintf('%04d',$errorCount); ?></div>
			</div>
			<div class="right_btn">
				<div class="right_txt"><?php echo sprintf('%d',$scoreCount); // sprintf('%04d',$scoreCount); ?></div>
			</div>
		</div>

		<div id="question_nr">
			<p><?php echo $problem_info->question; ?></p>
		</div>

		<dl id="question_answer">
			<?php foreach( $answer_list as $key=>$answer ){ ?>
				<a href="/game/lower-brain/problem.php?act=check&qid=<?php echo $problem_info->id  ?>&aid=<?php echo $answer->id; ?>">
					<?php
						switch( $key )
						{
							case 0:
								$type = 'a_bg';
							break;

							case 1:
								$type = 'b_bg';
							break;

							case 2:
								$type = 'c_bg';
							break;

							case 3:
								$type = 'd_bg';
							break;
						}
					?>

					<dd id="<?php echo $type; ?>">
						<div class="txt"><?php echo $answer->text;  ?></div>
					</dd>
				</a>
			<?php } ?>
		</dl>
	</div>
</body>
</html>

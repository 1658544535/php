<!doctype html>
<html lang="zh">
<head>
	<meta charset="utf-8">
	<!--IOS中Safari允许全屏浏览-->
	<meta content="yes" name="apple-mobile-web-app-capable">
	<meta content="email=no" name="format-detection" />
	<meta content="telephone=no" name="format-detection">
	<title>您的宝宝会是下一个“洪荒之力”吗？</title>
	<link rel="stylesheet" type="text/css" href="<?php echo __CURRENT_TPL_URL__;?>/css/style.css" />
	<script src="<?php echo __CURRENT_TPL_URL__;?>/js/flexible.js"></script>
	<?php include_once(CURRENT_TPL_DIR.'share.php'); ?>
</head>

<body>
    <div class="wrap">
    	
		<header class="test2-title">
			<i class="test2-title-num">2</i>
			<h1 class="test2-title-txt">选择宝宝已经GET的技能</h1>
		</header>

		<form id="step2Form" action="<?php echo __CURRENT_ROOT_URL__;?>/?act=2" method="post">
			<section class="test2-content">
				<?php foreach($fields as $key => $val){ ?>
					<div class="test2-skill-<?php echo $val['group_style'];?>">
						<?php foreach($val['items'] as $k => $v){ ?>
							<label class="test2-skill">
								<input type="checkbox" name="item[]" value="<?php echo $key.'-'.$k;?>" />
								<div class="test2-skill-bg"></div>
								<i class="test2-skill-icon"></i>
								<div class="test2-skill-txt"><b><?php echo $v['indication'];?></b></div>
							</label>
						<?php } ?>
					</div>
				<?php } ?>
			</section>
			<a class="test2-seeResult" onclick="$('#step2Form').submit();"></a>
		</form>

    </div>

    <script src="<?php echo __CURRENT_TPL_URL__;?>/js/jquery-2.1.4.min.js"></script>
    <script>
    	$(function(){
    		$(".test2-skill").each(function(index, el) {
    			var oCheck = $(el).find("input:checkbox");
    			if(oCheck.is(":checked")){
    				$(el).addClass("active");
    			}
    		});
    		$(".test2-skill input:checkbox").bind("change",function(){
    			if($(this).is(":checked")){
    				$(this).parent().addClass("active");
    			}else{
    				$(this).parent().removeClass("active");
    			}
    		});
    	});
    </script>
	<?php include_once(CURRENT_TPL_DIR.'statistics.php'); ?>
</body>
</html>

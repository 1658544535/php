<!DOCTYPE html>
<html>
<head>
	<title>拼得好</title>
	<style>
	body{background:#f2f2f2;background:-webkit-linear-gradient(0deg,#eee 0,#fff 46%,#eee 100%);background:-moz-linear-gradient(90deg,#eee 0,#fff 46%,#eee 100%);background:linear-gradient(90deg,#eee 0,#fff 46%,#eee 100%);background-position:50% 50%;-webkit-background-origin:padding-box;background-origin:padding-box;-webkit-background-clip:border-box;background-clip:border-box;-webkit-background-size:auto auto;background-size:auto auto;}
	.transfer_state{margin-top:10%;padding:20px;min-height:50px;line-height:24px;font-size:20px;font-weight:bold;text-align:center;}
	.transfer_success{color:#579336;}
	.transfer_fail{color:#c73d25;}
	.transfer_state i{display:inline-block;vertical-align:middle;width:50px;height:50px;margin-right:10px;background-repeat:no-repeat;background-position:0 0;background-size:50px 50px;}
	.transfer_state span{display:inline-block;vertical-align:middle;max-width:300px;text-align:left;}
	.transfer_success i{background-image:url(<?php echo __IMAGE__;?>success.png);}
	.transfer_fail i{background-image:url(<?php echo __IMAGE__;?>fail.png);}
	.transfer_jump{text-align:center;font-size:14px;color:#333;}
	.transfer_jump a{margin:0 5px;color:#333;text-decoration:underline;}
	.transfer_jump #wait{margin-left:5px;}
	</style>
</head>
<body>
	<?php if($status) {?>
		<div class="transfer_state transfer_success"><i></i><span><?php echo $msg;?></span></div>
	<?php }else{?>
		<div class="transfer_state transfer_fail"><i></i><span><?php echo $msg;?></span></div>
	<?php }?>
    <div class="transfer_jump">页面自动<a id="href" href="<?php echo $url;?>">跳转</a>等待时间<b id="wait"><?php echo $second;?></b></div>

	<script type="text/javascript">
	(function() {
	    var wait = document.getElementById('wait'),
	        href = document.getElementById('href').href;
	    var interval = setInterval(function() {
	        var time = --wait.innerHTML;
	        if (time <= 0) {
	            location.href = href;
	            clearInterval(interval);
	        };
	    }, 1000);
	})();
	</script>
</body>
</html>
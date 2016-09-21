<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="zh-CN">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=100%; initial-scale=1; maximum-scale=1; minimum-scale=1; user-scalable=no;" />
<meta content="telephone=no" name="format-detection" />
<title><?php echo $site_name;?></title>
<link href="/css/index3.css" rel="stylesheet" type="text/css" />
<link href="/css/common.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="js/jquery-1.8.3.min.js"></script>
<script src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>
<script type="text/javascript" src="/js/wxshare.js"></script>
<script>
	wxshare( <?php echo WXJSDEBUG;?>, '<?php echo WXJSAPPID;?>', <?php echo WXJSTIMESTAMP;?>, '<?php echo WXJSNONCESTR;?>', '<?php echo WXJSSIGNATURE;?>', '<?php echo WEBLOGO;?>', '<?php echo $SHARP_URL;?>', '<?php echo WEBTITLE;?>', '<?php echo WEBDESC;?>' )
</script>
<style>
	.order-wrapper{ padding:20px 0; }
	.order-wrapper #title{ text-align:center; font-size:16px; padding:20px 0 50px; }
	.order-wrapper #title a{ color:#df434e; font-size:16px; padding-left:10px; }


	.order-wrapper .nav_warp { height:30px; line-height:30px; border-top:1px dashed #e3e3e3;  }
	.order-wrapper .nav_warp dd{ width:50%; float:left; text-align:center; color:#666; }
	.order-wrapper .nav_warp dd a{ color:#666; }
</style>

</head>

<body>
	<div class="list-nav">
		<a href="<?php echo $_GET['return_url']; ?>" class="back"></a>
	    <div class="member-nav-M">请先绑定/完善帐号信息</div>
	</div>

	<div class="order-wrapper">
		<p id="title">您需要先绑定/完善帐号信息 <a href="/user_binding">我要前往</a></p>
		<dl class="nav_warp">
			<dd><a href="/">回到首页</a></dd>
			<dd><a href="/product">随便逛逛</a></dd>
			<div class="clear"></div>
		</dl>
	    <div class="clear"></div>
	</div>

	</br>
	</br>
	</br>
	</br>
	</br>
	</br>
	<?php include "footer_web.php"; ?>
	</br>
	</br>
	</br>
	<?php include "footer_menu_web_tmp.php"; ?>

</body>
</html>

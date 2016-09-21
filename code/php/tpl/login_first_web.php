<html xmlns="http://www.w3.org/1999/xhtml" lang="zh-CN">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta charset="utf-8" name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" />
<title><?php echo $site_name;?></title>
<link href="css/index4.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="js/jquery-1.4.2.min.js"></script>
<script type="text/javascript" src="js/jquery.cycle.all.js"></script>
<script src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>
<script type="text/javascript" src="/js/wxshare.js"></script>
<script>
	wxshare( <?php echo WXJSDEBUG;?>, '<?php echo WXJSAPPID;?>', <?php echo WXJSTIMESTAMP;?>, '<?php echo WXJSNONCESTR;?>', '<?php echo WXJSSIGNATURE;?>', '<?php echo WEBLOGO;?>', '<?php echo $SHARP_URL;?>', '<?php echo WEBTITLE;?>', '<?php echo WEBDESC;?>' )
</script>
<style type="text/css">
.clearfix:before,.clearfix:after{
     content:"";
     display:table;
}
.clearfix:after{clear:both;}
.clearfix{
     *zoom:1;/*IE/7/6*/
}
 *{ margin:0 auto; padding:0;}
 .box{ width:320px; height:auto; margin:10px auto 40px;}
 .bd-btn a{ text-decoration:none; color:#fff;}
 .bd-btn{ margin-top:20px;}
</style>
</head>

<body style="background:#f9f9f9;">
<div class="list-nav">
	<div class="member-nav-M">欢迎关注淘竹马</div>
</div>

<div class="box  clearfix">
	<div class="clearfix">
		<img src="images/image/tzm-logo.png" />
	</div>
	<div class="clearfix bd-btn">
		<a href="user_binding?openid=<?php echo $openid;?>"><span style="font-size:14px;  padding:9px 20px; background:#df434e; border:1px solid #de3945; float:left; margin-left:12px;">有帐号，请绑定</span></a>
		<a href="user_registered?type=1&openid=<?php echo $openid;?>"><span style="font-size:14px; padding:9px 20px; background:#df434e; border:1px solid #de3945; float:right; margin-right:12px;">没帐号，请注册</span></a>
	</div>
</div>
</form>
<?php include "footer_web.php";?>

</body>
</html>

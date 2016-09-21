<!doctype html>
<html lang="zh">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1, user-scalable=no" />
<title>关于淘竹马</title>
<link href="/css/common.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="/js/jquery-1.11.0.min.js"></script>
<script src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>
<script type="text/javascript" src="/js/wxshare.js"></script>
<script>
	wxshare( <?php echo WXJSDEBUG;?>, '<?php echo WXJSAPPID;?>', <?php echo WXJSTIMESTAMP;?>, '<?php echo WXJSNONCESTR;?>', '<?php echo WXJSSIGNATURE;?>', '<?php echo WEBLOGO;?>', '<?php echo $SHARP_URL;?>', '<?php echo WEBTITLE;?>', '<?php echo WEBDESC;?>' )
</script>
<style>
	.u_l_l_set{margin-top:0;}
	.u_l_l_set li a{padding-left:0;}
	.user_about_cr{margin-bottom:10px;text-align:center;line-height:20px;color:#666;padding:15px 0;background:#fff;}
	.user_about_cr img{width:30%;margin-bottom:10px;}
</style>
</head>
<body>
<div id="header">
	<a href="javascript:history.back(-1);" class="header_back"></a>
	<p class="header_title">关于淘竹马</p>
</div>

<img src="../images/abouttzm01.png" style="display:block;" />

<div class="user_warp">
	<ul class="user_line_list u_l_l_set">
		<li><a href="help?act=content&pid=1">用户使用协议</a></li>
		<li><a href="help?act=content&pid=1">特别声明</a></li>
	</ul>
</div>

<div class="user_about_cr">
	<img src="../images/aboutuscode.png" />
	<p>邀请好友扫描下载淘竹马客户端</p>	
	<p>Copyright ©2015 广东群宇互动科技有限公司</p>
</div>

<?php include "footer_web.php";?>

</body>
</html>

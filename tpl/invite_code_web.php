<!doctype html>
<html lang="zh">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1, user-scalable=no" />
<title>输入邀请码</title>
<link href="/css/common.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="/js/jquery-1.11.0.min.js"></script>
<script src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>
<script type="text/javascript" src="/js/wxshare.js"></script>
<script>
	wxshare( <?php echo WXJSDEBUG;?>, '<?php echo WXJSAPPID;?>', <?php echo WXJSTIMESTAMP;?>, '<?php echo WXJSNONCESTR;?>', '<?php echo WXJSSIGNATURE;?>', '<?php echo WEBLOGO;?>', '<?php echo $SHARP_URL;?>', '<?php echo WEBTITLE;?>', '<?php echo WEBDESC;?>' )
</script>
</head>
<body style="background:#fff9b1;">
<div id="header">
	<a href="javascript:history.back(-1);" class="header_back"></a>
	<p class="header_title">输入邀请码</p>
</div>


<div class="invite">
	<?php if( $user->inviter_id == null ){ ?>
		<img src="../images/tzm401.png" />
		<h3>输入邀请码帮好友赚钱</h3>
		<div class="invite_form">
			<form action="/invite.php">
				<input type="hidden" name="act" value="add_save" />
				<input type="text" name="code" placeholder="请输入邀请码" />
				<input type="submit" value="立即兑换" class="btn" />
			</form>
		</div>
	<?php }else{ ?>
		<img src="../images/tzm403.png" style="display:block;width:60%;margin:60px auto 0;" />
		<p>
			亲爱哒，您已经是淘竹马的用户啦。只有新用户注册才能用邀请码兑现哦~快将您的邀请码
			<span>ABCDEF</span>
			分享给其他的小伙伴来获取奖金吧！邀请越多，您的奖金越多哦~
		</p>
		<div class="invite_form">
			<a href="#" class="btn">立即去分享</a>
		</div>
	<?php } ?>
</div>

<?php include "footer_web.php";?>

</body>
</html>

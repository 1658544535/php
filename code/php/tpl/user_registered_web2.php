<html xmlns="http://www.w3.org/1999/xhtml" lang="zh-CN">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta charset="utf-8" name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" />
<title><?php echo $site_name;?></title>
<link href="css/index4.css" rel="stylesheet" type="text/css" />
<link href="/css/common.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="js/jquery-1.4.2.min.js"></script>
<script type="text/javascript" src="js/jquery.cycle.all.js"></script>
<script src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>
<script type="text/javascript" src="/js/wxshare.js"></script>
<script>
	wxshare( <?php echo WXJSDEBUG;?>, '<?php echo WXJSAPPID;?>', <?php echo WXJSTIMESTAMP;?>, '<?php echo WXJSNONCESTR;?>', '<?php echo WXJSSIGNATURE;?>', '<?php echo WEBLOGO;?>', '<?php echo $SHARP_URL;?>', '<?php echo WEBTITLE;?>', '<?php echo WEBDESC;?>' )
</script>
</head>

<body>
	<div class="list-nav">
		<a href="javascript:window.history.back(-1);"class="back"></a>
	    <div class="member-nav-M">用户资料填写</div>
	</div>

	<form action="user_registered" method="post" onsubmit="return tgSubmit()">
		<input type="hidden" name="act" value="get_code2" />
		<input type="hidden" name="openid" value="<?php echo $openid;?>" />
		<input type="hidden" name="type" value="<?php echo $type;?>" />
		<input type="hidden" name="promotion" value="<?php echo $promotion;?>" />
		<div class="index-wrapper">

		   <div class="add-txt">
		   		<p style="border-bottom:1px dashed #e3e3e3; margin-bottom:20px;">请完善您的个人信息</p>
				手　　机：<input id="tel" name="tel" type="text" value="" class="add-txt-name" placeholder="请填写您的手机号码" style="width:71%;"/>
			    <div class="add-button">
			   	 	<input type="submit" value="获取验证码" class="add-button-y" />
			    </div>
		    </div>
		</div>
	</form>

	</br>
	</br>
	</br>
	</br>
	<?php include "footer_web.php";?>
	</br>
	</br>
	<?php include "footer_menu_web_tmp.php"; ?>

	<script type="text/javascript">
		$(function(){
			$("#tip").hide();
		})

		function isInt(a)
		{
		    var reg = /^(\d{11})$/;
		    return reg.test(a);
		}

		function tgSubmit()
		{
			var tel=$("#tel").val();
			if($.trim(tel) == ""){
				alert('请填写手机号！');
				return false;
			}

			if(!isInt(tel)){
				alert('手机号码必须为11位数字！');
				return false;
			}

			return true;
		}
	</script>

	</body>
</html>

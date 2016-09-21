<html xmlns="http://www.w3.org/1999/xhtml" lang="zh-CN">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta charset="utf-8" name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" />
<title>淘竹马</title>
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

	<?php if ( $str == 1 ){ ?>
	<form action="user_registered" method="post" onsubmit="return tgSubmit()">
		<input type="hidden" name="act" value="post2" />
		<input type="hidden" name="openid" value="<?php echo $openid;?>" />
		<input type="hidden" name="type" value="<?php echo $type;?>" />
		<input type="hidden" name="promotion" value="<?php echo $promotion;?>" />
		<input type="hidden" name="tel" value="<?php echo $phone;?>" />
		<div class="index-wrapper">

		   <div class="add-txt">
		   		<p style="border-bottom:1px dashed #e3e3e3; margin-bottom:20px;">请输入验证码</p>
		   		请输入验证码：
		   		<input id="code" name="code" type="text" value="" class="add-txt-name" style="width:100px; margin-left:20px;" maxlength=6 />

			    <div class="add-button">
			   	 	<input type="submit" value="提交" class="add-button-y" />
			    </div>
		    </div>
		</div>
	</form>
	<?php } else if ( $str == -3 ){ ?>
		<div class="add-txt">
		   <p style="border-bottom:1px dashed #e3e3e3; margin-bottom:20px;">您的手机已注册 <a href='/' style='color:#df434e;' >进入商城</a></p>
		</div>
	<?php }  else if ( $str == -1 ){ ?>
		<div class="add-txt">
		   <p style="border-bottom:1px dashed #e3e3e3; margin-bottom:20px;">请不要频繁申请验证码！ <a href="javascript:window.history.back(-1);" style="color:#df434e;">点击返回</a> </p>
		</div>
	<?php }  else if ( $str == -1 ){ ?>
		<div class="add-txt">
		   <p style="border-bottom:1px dashed #e3e3e3; margin-bottom:20px;">验证码获取失败，请返回重试！ <a href="javascript:window.history.back(-1);" style="color:#df434e;">点击返回</a> </p>

		</div>
	<?php } ?>

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
			var code=$("#code").val();
			if($.trim(code) == ""){
				alert('请填写验证码！');
				return false;
			}
			return true;
		}

	</script>

	</body>
</html>

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

	<dl class="favs_tabs" style="padding-top:10px; background:#fff; margin-bottom:0px;">
		<a href="/user_binding">
			<dd class="large">我要登录</dd>
		</a>
		<dd class="large" id="active_tab">我要注册</dd>
		<div class="clear"></div>
	</dl>

	<form action="user_registered" method="post" onsubmit="return tgSubmit()">
		<input type="hidden" name="act" value="post" />
		<input type="hidden" name="openid" value="<?php echo $openid;?>" />
		<input type="hidden" name="type" value="<?php echo $type;?>" />
		<div class="index-wrapper">

		   <div class="add-txt">
		   		<p style="border-bottom:1px dashed #e3e3e3; margin-bottom:20px;">
		    		请完善您的个人信息
		    	</p>
			手　　机：<input id="tel" name="tel" type="text" value="" class="add-txt-name" placeholder="请填写您的手机号码" style="width:71%;"/>
		   </br>
		   	验 证 码： <input id="code" name="code" type="text" value="" class="add-txt-name" style="width:100px; margin-left:20px;" maxlength=6 />
		   		  <input type='button' class="code_btn" value="获取验证码" style="padding:5px 2px; background:#df434; font-size:" onclick='get_code()' />
		   		  <span id='tip' style="font-size:12px; padding-left:10px;" ><span id="time">60</span> 秒后重新发送</span>
		   </br>
			密　　码：<input id="password" name="password" type="password" value="" class="add-txt-name" placeholder="请填写您的密码" style="width:71%;"/>
		    </br>
		    确认密码：<input id="repassword" name="repassword" type="password" value="" class="add-txt-name" placeholder="请填写您的密码" style="width:71%;"/>
		    </br>
			昵　　称：<input id="name" name="name" type="text" value="<?php echo $user->name; ?>" class="add-txt-name" placeholder="请填写您的昵称" style="width:71%;"/>

		    <div class="add-button"> <input type="submit" value="提交" class="add-button-y" /></div>
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

		function tgSubmit(){
			var tel=$("#tel").val();
			if($.trim(tel) == ""){
				alert('请填写手机号！');
				return false;
			}
			if(!isInt(tel)){
				alert('手机号码必须为11位数字！');
				return false;
			}
			var code=$("#code").val();
			if($.trim(code) == ""){
				alert('请填写验证码！');
				return false;
			}

			var password=$("#password").val();
			if($.trim(password) == ""){
				alert('请填写密码！');
				return false;
			}

			var repassword=$("#repassword").val();
			if($.trim(repassword) == ""){
				alert('请填写确认密码！');
				return false;
			}

			if( password != repassword )
			{
				alert('请输入的密码和确认密码不匹配！');
				return false;
			}

			var name=$("#name").val();
			if($.trim(name) == ""){
				alert('请填写昵称！');
				return false;
			}
			return true;
		}

		function get_code()
		{
			$.ajax({
				type: "GET",
             	url: "/user_registered?act=get_code&tel=" + $("#tel").val(),
             	success: function(data){
             		switch(data)
             		{
             			case "-4":
             				alert("验证码发送失败！");
             			break;

             			case "-3":
             				alert("此手机号已被注册！");
             			break;

             			case "-2":
             				alert("请输入正确的手机号码！");
             			break;

             			case "-1":
             				alert("1分钟内不要频繁发送！");
             			break;

             			case "1":
             				alert("验证码发送成功！");
             				$(".code_btn").hide();
             				$("#tip").show();
             				getclock();
             			break;
             		}
                }
			})

		}

		// 计时器
		function getclock()
		{
			var seconds = 0;
			var time = setInterval(function(){
				seconds += 1;
				document.getElementById('time').innerHTML = 60-seconds;

				if (seconds == 60)
				{
					$(".code_btn").show();
             		$("#tip").hide();
             		document.getElementById('time').innerHTML = 60;
             		 clearTimeout(time);
				}
			},1000);
		}
	</script>

	</body>
</html>

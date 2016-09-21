<!doctype html>
<html>
<head>
<meta charset="utf-8">
<meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, minimal-ui, user-scalable=0" name="viewport">
<!--IOS中Safari允许全屏浏览-->
<meta content="yes" name="apple-mobile-web-app-capable">
<!--IOS中Safari顶端状态条样式-->
<meta content="black" name="apple-mobile-web-app-status-bar-style">
<title>个人信息</title>
<script src="<?php echo $site; ?>js/jquery.min.js"></script>
<style>
html,body{width:100%;height:100%;margin:0;padding:0;font-family:"Microsoft YaHei";font-size:12px;}
body{background:url(images/wx_bg.png);background-size:4% auto;}
input{-webkit-appearance:none;border-radius:0;}
.wrapper,body{height:100%;overflow:hidden;}
.login{position:relative;width:82%;margin:22% auto 0;padding-bottom:82%;border-radius:50%;background:url(images/wx_login_bg.png) 0 0;background-size:100% 100%;}
.login h1{position:absolute;top:10%;left:0;width:100%;text-align:center;font-size:28px;color:#eb6da5;font-weight:normal;}
.login ul{padding:0;margin:0;position:absolute;left:50%;top:50%;width:67%;-webkit-transform:translate(-56%,-50%);transform:translate(-56%,-50%);}
.login ul li{position:relative;list-style:none;}
.phone{padding-bottom:14px;}
.txt{padding:0;line-height:30px;line-height:30px;border:1px solid #b5b5b6;border-radius:6px;background-size:auto 66%;background-position:4px center;background-repeat:no-repeat;text-indent:30px;outline:none;color:#666;background-color:#ebebeb;}
.phone .txt{width:100%;background-image:url(images/wx_phone.png);}
.code .txt{width:70%;background-image:url(images/wx_code.png);}
.btn{position:absolute;right:0;top:50%;width:38%;line-height:25px;height:25px;padding:0;color:#eb6da5;border-radius:25px;border:1px solid #eb6da5;background:#ebebeb;outline:none;-webkit-transform:translate(40%,-50%);transform:translate(40%,-50%);}
.submit_bg{position:relative;width:30%;float:right;padding-bottom:30%;z-index:-1;-webkit-transform:translate(-35%,-64%);transform:translate(-35%,-64%);background:url(images/wx_go.png) no-repeat center center;background-size:100% auto;background-color:#e9e9e9;border-radius:50%;}
.submit{position:absolute;width:45%;bottom:0;right:0;padding-bottom:45%;z-index:-1;-webkit-transform:translate(5%,50%);transform:translate(5%,50%);border-radius:50%;z-index:999;-webkit-opacity:0;opacity:0;}
.submit input{position:absolute;width:100%;height:100%;background:none;border:none;}
.code_tips{position:absolute;left:0;top:35px;margin:0;color:#666;}
@media screen and (max-width: 360px) {html{font-size:10px;}}
</style>
</head>

<body>
	<div class="wrapper">
	    <form action="reg.php" method="post" onsubmit="return tgSubmit()">
	    	<input type="hidden" name="act" value="post" />
		    <div class="login">
		        <h1>个人信息</h1>
		        <ul>
		            <li class="phone">
		                <input type="text" class="txt" placeholder="请输入11位手机号码" name="tel" id="tel" />
		            </li>
		            <li class="code">
		                <input type="text" class="txt" placeholder="请输入短信验证码" name="code" id="code" />
		                <input type="button" value="获取验证码" class="btn code_btn"  onclick='get_code()' />
		                <p id='tip' class="code_tips" ><span id="time">60</span> 秒后重新发送</p>
		            </li>

		        </ul>
		        <div class="submit"><input type="submit" value="" /></div>
		    </div>
	    	<div class="submit_bg"></div>
	    </form>
	</div>

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

			return true;
		}

		function get_code()
		{
			$.ajax({
				type: "GET",
				dataType: 'json',
             	url: "<?php echo $site ?>reg.php?act=get_code&tel=" + $("#tel").val(),
             	success: function(data){
             		if ( parseInt(data.code) > 0 )
             		{
             			alert("验证码发送成功！");
             			$(".code_btn").hide();
             			$("#tip").show();
             			getclock();
             		}
             		else
             		{
             			alert( data.msg );
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

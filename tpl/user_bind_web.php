<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title><?php echo $site_name;?></title>
    <meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, minimal-ui, user-scalable=0" name="viewport">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <link rel="stylesheet" href="css/sm.min.css">
    <link rel="stylesheet" href="css/all.min.css?v=<?php echo SOURCE_VERSOIN;?>">
    <link rel="stylesheet" href="js/swiper/swiper.min.css">
    <script type='text/javascript' src='js/jquery-2.1.4.min.js' charset='utf-8'></script>
    <script>jQuery.noConflict()</script>
    <script type='text/javascript' src='js/zepto.js' charset='utf-8'></script>
    <script type='text/javascript' src='js/baiduTemplate.js' charset='utf-8'></script>
    <script type='text/javascript' src='js/sui/sm.min.js' charset='utf-8'></script>
    <script type='text/javascript' src='js/swiper/swiper.min.js' charset='utf-8'></script>
    <script type='text/javascript' src='js/app.min.js?v=<?php echo SOURCE_VERSOIN;?>' charset='utf-8'></script>
    <script src="http://static.geetest.com/static/tools/gt.js"></script>
    <?php include_once('wxshare_web.php');?>
</head>
<body>
    <div class="page-group" id="page-login">
        <div id="page-nav-bar" class="page page-current bgWhite">
            <header class="bar bar-nav bar-nav-login">
                <a class="button button-link button-nav pull-left back" href="javascript:history.back(-1);">
                    <span class="icon icon-back"></span>
                </a>
                <!-- <h1 class="title">手机登录</h1> -->
            </header>

            <div class="content">
				<section class="login-header">
					<h1>登录</h1>
					<p>请确保你的手机畅通，用于接收验证码短信</p>
				</section>

                <form action="user_binding" method="post" onsubmit="return tgSubmit()">
					<input type="hidden" name="openid" value="<?php echo $openid;?>" />
                    <section class="edit-list-icon">
                        <ul class="list">
                            <li>
                                <!-- <i class="icon icon-tel"></i> -->
                                <div class="input-controll"><input type="tel" name="mobile" id="mobile" class="txt" placeholder="手机号码" /></div>
                            </li>
                            <li>
                                <!-- <i class="icon icon-code"></i> -->
                                <div class="input-controll"><input type="tel" name="code" id="code" class="txt" placeholder="验证码" /></div>
                                <a href="javascript:;" class="btn" id="JS-vcodebtn" onclick="show_captcha()">发送验证码</a>
								<span id='tip' class="btn btn-gray">&nbsp;&nbsp;<span id="time">0</span>&nbsp;秒后重发</span>
                            </li>
                        </ul>
						<div id="captcha" style="margin:0 10px;"></div>
                    </section>

                    <div class="bin-btn">
                        <input type="submit" value="登录" />
                    </div>
                </form>
            </div>
            

        </div>
    </div>
	<script type="text/javascript">

		$("#mobile, #code").on("keyup", function(){
			var checkOk = true;
			var mobile = $("#mobile").val();
			if(!_checkMobile(mobile)){
				checkOk = false;
			}
			if($.trim($("#code").val()) == ""){
				checkOk = false;
			}
			if(checkOk){
				$(".bin-btn").addClass("active");
			}else{
				$(".bin-btn").removeClass("active");
			}
		});

		function get_code( v_geetest_challenge, v_geetest_validate, v_geetest_seccode,captchaObj  )
		{
			$.ajax({
				type: "POST",
				dataType: "json",
             	url: "/user_registered?act=get_code&tel=" + $("#mobile").val(),
             	data:{
	          			'geetest_challenge' :  v_geetest_challenge,
						'geetest_validate'  :  v_geetest_validate,
						'geetest_seccode'   :  v_geetest_seccode
	          	},
             	success: function(data){
             		if(data.code > 0){
						$.toast("验证码发送成功！");
         				$(".code_btn").hide();
         				$("#tip").show();
         				getclock();
         				$("#captcha").empty();
             		}else{
						$.toast(data.msg);
             			captchaObj.refresh();
             			// show_captcha();
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

		function tgSubmit()
		{
			if(!_checkMobile($("#mobile").val()))
			{
				$.toast("请输入正确的帐号");
				return false;
			}

			if($.trim($("#code").val()) == "")
			{
				$.toast("请输入验证码");
				return false;
			}

			return true;
		}


		//验证码
		function handler(captchaObj) {
			$("#captcha").empty();
	        // 将验证码加到id为captcha的元素里
	        // captchaObj.appendTo("#captcha");
	        captchaObj.appendTo("#captcha");

	        captchaObj.onSuccess(function() {
				var v_geetest_challenge = $('.geetest_challenge').val();
	        	var v_geetest_validate = $('.geetest_validate').val();
	        	var v_geetest_seccode = $('.geetest_seccode').val();

	        	get_code( v_geetest_challenge, v_geetest_validate, v_geetest_seccode, captchaObj );
	        });
	    };
	    var xhr = "";
	    function show_captcha(){
			var mobile = $.trim($("#mobile").val());
			if(mobile == ""){
				$.toast("请输入手机号");
				return false;
			}else if(!_checkMobile(mobile)){
				$.toast("请正确输入手机号");
				return false;
			}
//			get_code();
 	     	if(!!xhr){
 	     		$("#captcha").html("");
 				xhr.abort();		//取消未请求完成的ajax
 			}
 	     	xhr = $.ajax({
 		        // 获取id，challenge，success（是否启用failback）
 		        url: "/validate.php?act=init_geetest",
 		        type: "get",
 		        dataType: "json", // 使用jsonp格式
 		        success: function (data) {
 		            // 使用initGeetest接口
 		            // 参数1：配置参数，与创建Geetest实例时接受的参数一致
 		            // 参数2：回调，回调的第一个参数验证码对象，之后可以使用它做appendTo之类的事件
 		            $("#captcha").html("");
 		            initGeetest({
 		                gt: data.gt,
 		                challenge: data.challenge,
 		                product: "embed", // 产品形式embed
 		                offline: !data.success,
 		                width: "100%"
 		            }, handler);
 		        }
 		    });
	    }

		function _checkMobile(_mobile){
			var re = /^1\d{10}/;
			return re.test(_mobile);
		}
	</script>
</body>

</html>

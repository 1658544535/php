<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>淘竹马</title>
    <meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, minimal-ui, user-scalable=0" name="viewport">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <link rel="stylesheet" href="css/sm.min.css">
    <link rel="stylesheet" href="css/all.min.css">
    <link rel="stylesheet" href="js/swiper/swiper.min.css">
    <script type='text/javascript' src='js/zepto.js' charset='utf-8'></script>
    <script type='text/javascript' src='js/baiduTemplate.js' charset='utf-8'></script>
    <script type='text/javascript' src='js/sui/sm.min.js' charset='utf-8'></script>
    <script type='text/javascript' src='js/swiper/swiper.min.js' charset='utf-8'></script>
    <script type='text/javascript' src='js/app.min.js' charset='utf-8'></script>
</head>

<body>
    <div class="page-group" id="page-getCoupon">
        <div id="page-nav-bar" class="page page-current">
            <header class="bar bar-nav">
                <a class="button button-link button-nav pull-left back" href="">
                    <span class="icon icon-back"></span>
                </a>
                <h1 class="title">领取优惠券</h1>
            </header>

            <div class="content">
                <div class="getCoupon">
                    <div class="bg-header"></div>
                    <div class="bg-footer"></div>
                    <form class="form" action="user_coupon.php" method="post" onsubmit="return tgSubmit()">
                        <?php if($bLogin ==''){?>
                        <div class="formItem">
                            <input id="mobile" class="form-control" type="tel" name="mobile" value="" placeholder="输入手机号码" />
                        </div>
                        <div class="formItem2">
                            <div class="btn code_btn"><a href="javascript:get_code();">获取验证码</a></div>
                            <div id="time">60&nbsp;秒后重发</div>
                            <div class="control"><input id="code" class="form-control" type="tel" name="code" value="" placeholder="输入验证码" /></div>
                        </div>
                        <?php }?>
                        <div class="formItem">
                            <input id="coupon" class="form-control" type="text" name="number" value="" placeholder="输入兑换码" />
                        </div>
                        <div class="formSubmit">
                            <input class="form-submit" type="submit" value="领取优惠券" />
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <script>
            $(document).on("pageInit", "#page-getCoupon", function(e, pageId, page) {

            })
            function get_code(){
                if(!_checkMobile($("#mobile").val())){
    				$.toast("请输入正确的手机号码");
    				return false;
    			}
    			$.ajax({
    				type: "POST",
    				dataType: "json",
                 	url: "/user_registered",
                 	data:{
                        'act': 'get_code',
    	          		'tel' :  $("#mobile").val()
    	          	},
                 	success: function(data){
                 		if(data.code > 0){
    						$.toast("验证码发送成功！");
             				$(".code_btn").hide();
             				$("#time").show();
             				getclock();
                 		}else{
    						$.toast(data.msg);
                 		}
                    }
    			})
    		}

            // 计时器
    		function getclock(){
    			var seconds = 0,
                    txt = '&nbsp;秒后重发';
    			var time = setInterval(function(){
    				seconds += 1;
    				document.getElementById('time').innerHTML = 60-seconds + txt;
    				if (seconds == 60){
    					$(".code_btn").show();
                 		$("#time").hide();
                 		document.getElementById('time').innerHTML = 60 + txt;
                 		 clearTimeout(time);
    				}
    			},1000);
    		}

            // 验证
            function tgSubmit(){
    			if(!_checkMobile($("#mobile").val()) && $("#mobile").length>0)
    			{
    				$.toast("请输入正确的手机号码");
    				return false;
    			}

    			if($.trim($("#code").val()) == "" && $("#code").length>0)
    			{
    				$.toast("请输入验证码");
    				return false;
    			}

                if($.trim($("#coupon").val()) == "")
    			{
    				$.toast("请输入兑换码");
    				return false;
    			}

    			return true;
    		}
            function _checkMobile(_mobile){
    			var re = /^1\d{10}/;
    			return re.test(_mobile);
    		}
        </script>
    </div>
</body>

</html>

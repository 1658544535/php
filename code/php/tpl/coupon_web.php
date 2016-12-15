<?php include_once('header_web.php');?>
<?php include_once('wxshare_web.php');?>
<style>
    .modal.modal-in{
        width: 90.625%;
        margin-left: -45.3125%;
    }
    .modal-inner{
        padding: 1.2rem;
    }
    .modal-button{
        color: #3d4145;
    }
</style>

<body>
    <div class="page-group" id="page-getCoupon">
        <div id="page-nav-bar" class="page page-current">
            <div class="content">
            <a href="javascript:history.back(-1);" class="back deta-back" style="z-index: 4;"></a>
                <div class="getCoupon">
                    <div class="bg-header"></div>
                    <div class="bg-footer"></div>
                    <form class="form">
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
                            <input id="coupon" class="form-control" type="tel" name="number" value="" placeholder="输入兑换码" />
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
                $(".getCoupon .form").on("submit", function(){
                    var _form = $(this);
                    if(tgSubmit()){
                        $.ajax({
                            url: 'user_coupon.php',
                            data: _form.serialize(),
                            dataType: 'json',
                            success: function(req){
                                if(req.code == 1){
                                    // 弹成功弹窗
                                    $.modal({
                                        'title': '亲, 您的优惠券已兑换成功!<br/>您可到个人中心 - 我的优惠券 查看',
                                        buttons: [
                                            {
                                                text: '去看看',
                                                onClick: function(){
                                                    location.href="/user_info.php?act=coupon";
                                                }
                                            },
                                            {
                                                text: '继续逛',
                                                onClick: function(){
                                                    location.href="/index.php";
                                                }
                                            }
                                        ]
                                    })
                                    $(".code_btn").show();
                     				$("#time").hide();
                                }else if(req.code == 2){
                                    $.toast(req.data.data);
                                    $("#mobile").parent().remove();
                                    $("#code").parent().parent().remove();
                                }else{
                                    // 提示失败
                                    $.toast(req.data.data);
                                    $(".code_btn").show();
                     				$("#time").hide();
                                }
                            },
                            error: function(req){
                                $.toast('领取失败, 请重试');
                                $(".code_btn").show();
                 				$("#time").hide();
                            }
                        });
                    }
                    return false;
                });
            })
            function get_code(){
                if(!_checkMobile($("#mobile").val())){
    				$.toast("请输入正确的手机号码");
    				return false;
    			}
    			$.ajax({
    				type: "POST",
    				dataType: "json",
                 	url: "/user_registered.php",
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

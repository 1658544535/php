<!doctype html>
<html lang="zh">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1, user-scalable=no" />
<title><?php echo $site_name;?></title>
<link href="/css/common.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="/js/jquery-1.11.0.min.js"></script>
<script src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>
<script type="text/javascript" src="/js/wxshare.js"></script>
<style type="text/css">
    .bing_warp .form_warp dl dd input.i-verify{width:45%;}
    .btn-verify{float:right;border:1px #f72418 solid; border-radius:10px; margin:12px 20px 0 0; padding:3px 8px; color:#333; display:inline-block;}
    .bing_warp .btn_warp{margin-left:15px;margin-right:15px;}
</style>
<script>
    wxshare( <?php echo WXJSDEBUG;?>, '<?php echo WXJSAPPID;?>', <?php echo WXJSTIMESTAMP;?>, '<?php echo WXJSNONCESTR;?>', '<?php echo WXJSSIGNATURE;?>', '<?php echo WEBLOGO;?>', '<?php echo $SHARP_URL;?>', '<?php echo WEBTITLE;?>', '<?php echo WEBDESC;?>' )
</script>
</head>

<body style="background:#fff;">
    <div id="header">
        <a href="javascript:history.go(-1);" class="header_back"></a>
        <p class="header_title">找回密码</p>
    </div>

<div class="nr_warp">
    <div class="bing_warp">
        <div class="form_warp">
            <form action="forget.php" method="post" onsubmit="return tgSubmit()">
                <input type="hidden" name="openid" value="<?php echo $openid;?>" />

                <dl>
                    <dd>
                        <div class="bind-form-item">
                            <!-- <label>手机号　</label> -->
                            <input id="mobile" name="mobile" type="text" placeholder="请输入手机号"/>
                        </div>
                    </dd>

                    <dd>
                        <div class="bind-form-item">
                            <!-- <label>验证码　</label> -->
                            <input id="verify" name="verify" type="text" placeholder="请输入短信验证码" class="i-verify" />
                            <a id="btn-verify" class="btn-verify" href="javascript:;" onclick="sendVNo()">获取验证码</a>
                            <span id="verify-time" class="btn-verify" style="display:none;"></span>
                        </div>
                    </dd>

                    <dd>
                        <div class="bind-form-item">
                            <!-- <label>密　码　</label> -->
                            <input id="password" name="password" type="password" placeholder="请设置密码" style="width:70%;" />
                        </div>
                    </dd>
                </dl>

                <div class="btn_warp">
                    <input class="red_btn btn" type="submit" value="提交" />
                </div>
            </form>
        </div>
    </div>
</div>

<?php include "footer_web.php";?>
<script>

    function tgSubmit()
    {
        if($.trim($("#mobile").val()) == "")
        {
            alert('请输入手机号');
            return false;
        }

        if($.trim($("#verify")) == ""){
            alert("请输入验证码");
            return false;
        }

        if($.trim($("#password").val()) == "")
        {
            alert('请输入密码');
            return false;
        }
        return true;
    }

    function sendVNo(){
        var mobile  = $("#mobile").val();
        if($.trim(mobile) == ""){
            alert("请输入手机号");
            return false;
        }
        downcount(59);
        $("#btn-verify").hide();
        $("#verify-time").show();
        var url = "/forget.php?act=sendcaptcha&m="+mobile;
        $.get(url, function(result){
            alert(result.msg);
        }, "json");
    }

    function downcount(_time){
        if(_time > 0){
            $("#verify-time").html("稍等"+_time+"秒");
            setTimeout(function(){downcount(--_time)}, 1000);
        }else{
            $("#verify-time").hide();
            $("#btn-verify").show();
        }
    }
</script>

</body>
</html>

<!doctype html>
<html>
<head>
<meta charset="utf-8">
<meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, minimal-ui, user-scalable=0" name="viewport">
<!--IOS中Safari允许全屏浏览-->
<meta content="yes" name="apple-mobile-web-app-capable">
<!--IOS中Safari顶端状态条样式-->
<meta content="black" name="apple-mobile-web-app-status-bar-style">
<title>摇一摇</title>
<style>
*{ margin:0; padding:0; }
html,body{width:100%;margin:0;padding:0;background:#eb6da5;}
.wrapper{position:relative;width:100%;height:100%;}
.bg_top,.bg_top img,.main img{display:block;width:100%;height:auto;border:none;}
.bg_top{position:relative;z-index:2;}
.main{position:relative;width:100%;height:auto;}
.shake{position:absolute;top:0;left:0;width:100%;height:auto;-webkit-transform-origin: 54.7% 100%;-o-transform-origin: 54.7% 100%;-moz-transform-origin: 54.7% 100%;-ms-transform-origin: 54.7% 100%;transform-origin: 54.7% 100%;}
.myRecord{position:absolute;width:100%;top:71%;height:auto;z-index:3;}
.myRecord a{font-size:0;opacity:0;display:block;width:50%;margin:0 auto;padding-bottom:20%;background:#000;}

.popup{position:fixed;top:0;left:0;bottom:0;right:0;background-color:rgba(0,0,0,0.7);z-index:9;}
.popupMain{position:relative;display:inline-block;width:80%;background:#fff;border-radius:10px;padding:0 8px 16px;}
.popup_img{position:relative;width:100%;text-align:center;margin-top:-25%;}
.popup_img img{width:50%;border-radius:50%;border:4px solid #dc689b;}
.popup_tips{color:#717071;font-size:16px;line-height:23px;padding:18px 0;}
.popup_a{text-align:center;font-size:0;}
.popup_a a{display:inline-block;width:48%;padding-bottom:11.4%;margin:5px 1%;background-image:url(images/a.png);background-repeat:no-repeat;background-size:100% auto;}
.btn_shake{background-position:0 63%;}
.btn_see{background-position:0 0;}
.btn_share{background-position:0 32%;}
.btn_attention{background-position:0 96%;}
.popup_close{position:absolute;right:-12px;top:-12px;width:26px;height:26px;background:url(images/close.png) no-repeat;background-size:100% 100%;font-size:0;}

.share{width:100%;height:100%;background:url(images/share.png) no-repeat;background-size:100% auto;}

@-webkit-keyframes shake{0%,100%{-webkit-transform:rotate(0deg);}10%,50%,90%{-webkit-transform:rotate(-20deg);}30%,70%{-webkit-transform:rotate(20deg);}}
@-moz-keyframes shake{0%,100%{-moz-transform:rotate(0deg);}10%,50%,90%{-moz-transform:rotate(-20deg);}30%,70%{-moz-transform:rotate(20deg);}}
@-ms-keyframes shake{0%,100%{-ms-transform:rotate(0deg);}10%,50%,90%{-ms-transform:rotate(-20deg);}30%,70%{-ms-transform:rotate(20deg);}}
@-o-keyframes shake{0%,100%{-o-transform:rotate(0deg);}10%,50%,90%{-o-transform:rotate(-20deg);}30%,70%{-o-transform:rotate(20deg);}}
@keyframes shake{0%,100%{transform:rotate(0deg);}10%,50%,90%{transform:rotate(-20deg);}30%,70%{transform:rotate(20deg);}}


@-webkit-keyframes zoomIn {from {opacity: 0;-webkit-transform: scale3d(.3, .3, .3);}50% {opacity: 1;}}
@-moz-keyframes zoomIn {from {opacity: 0;-moz-transform: scale3d(.3, .3, .3);}50% {opacity: 1;}}
@-ms-keyframes zoomIn {from {opacity: 0;-ms-transform: scale3d(.3, .3, .3);}50% {opacity: 1;}}
@-o-keyframes zoomIn {from {opacity: 0;-o-transform: scale3d(.3, .3, .3);}50% {opacity: 1;}}
@keyframes zoomIn {from {opacity: 0;transform: scale3d(.3, .3, .3);}50% {opacity: 1;}}

@-webkit-keyframes zoomOut {from {opacity: 1;}50% {opacity: 0;-webkit-transform: scale3d(.3, .3, .3);}to{opacity: 0;}}
@-moz-keyframes zoomOut {from {opacity: 1;}50% {opacity: 0;-moz-transform: scale3d(.3, .3, .3);}to{opacity: 0;}}
@-ms-keyframes zoomOut {from {opacity: 1;}50% {opacity: 0;-ms-transform: scale3d(.3, .3, .3);}to{opacity: 0;}}
@-o-keyframes zoomOut {from {opacity: 1;}50% {opacity: 0;-o-transform: scale3d(.3, .3, .3);}to{opacity: 0;}}
@keyframes zoomOut {from {opacity: 1;}50% {opacity: 0;transform: scale3d(.3, .3, .3);}to{opacity: 0;}}

.animateShake{-webkit-animation: shake 1.6s;-moz-animation: shake 1.6s;-ms-animation: shake 1.6s;-o-animation: shake 1.6s;animation: shake 1.6s;}
.animateZoomIn{-webkit-animation:zoomIn 0.4s;-moz-animation:zoomIn 0.4s;-ms-animation:zoomIn 0.4s;-o-animation:zoomIn 0.4s;animation:zoomIn 0.4s;}
.animateZoomOut{-webkit-animation:zoomOut 0.4s;-moz-animation:zoomOut 0.4s;-ms-animation:zoomOut 0.4s;-o-animation:zoomOut 0.4s;animation:zoomOut 0.4s;}

</style>
</head>

<body>
<div class="wrapper">
    <div class="bg_top">
        <img src="images/bg-top.jpg" alt="摇一摇送福利">
    </div><!--头部-->

    <div class="main">
        <img src="images/bg-main.jpg" />
        <div class="shake"><img src="images/shake.png" /></div>
        <div class="myRecord"><a href="<?php $site ?>index.php?act=record">我的福利记录</a></div>
    </div><!--主体-->

    <!--<div class="popup"><div style="display:table;width:100%;height:100%;"><div style="display:table-cell;text-align:center;vertical-align:middle;"><div class="popupMain animateZoomIn">
        <div class="popup_img"><img src="images/pro.jpg" /></div>
        <div class="popup_tips">手气不错哦！<br/>获得了 美贝尔MS1400 布书6件套</div>
        <div class="popup_a"><a href="#" class="btn_share"></a><a href="#" class="btn_shake"></a></div>
        <span class="popup_close" onclick="closePopup()">关闭</span>
    </div></div></div></div>-->

</div>

<script src="js/jquery-2.1.4.min.js"></script>
<script src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>
<script type="text/javascript" src="/js/wxshare.js"></script>
<script>
	wxshare( <?php echo WXJSDEBUG;?>, '<?php echo WXJSAPPID;?>', <?php echo WXJSTIMESTAMP;?>, '<?php echo WXJSNONCESTR;?>', '<?php echo WXJSSIGNATURE;?>', '<?php echo WEBLOGO;?>', '<?php echo WEBLINK . "?oid=" . $_SESSION['shake_info']['openid'] . "&unid=" . $_SESSION['shake_info']['unionid'];?>', '<?php echo WEBTITLE;?>', '<?php echo WEBDESC;?>' )

	var yyState = true;
    var SHAKE_THRESHOLD = 800;
    var last_update = 0;
    var x = y = z = last_x = last_y = last_z = 0;

    if (window.DeviceMotionEvent) {
        window.addEventListener('devicemotion', deviceMotionHandler, false);
    } else {
        alert('本设备不支持devicemotion事件');
    }

    //摇一摇判断
    function deviceMotionHandler(eventData) {
        var acceleration = eventData.accelerationIncludingGravity;
        var curTime = new Date().getTime();

        if ((curTime - last_update) > 200) {
            var diffTime = curTime - last_update;
            last_update = curTime;
            x = acceleration.x;
            y = acceleration.y;
            z = acceleration.z;
            var speed = Math.abs(x + y + z - last_x - last_y - last_z) / diffTime * 10000;

            if (speed > SHAKE_THRESHOLD) {
                doResult();
                //window.removeEventListener('devicemotion', deviceMotionHandler, false);
            }
            last_x = x;
            last_y = y;
            last_z = z;
        }
    }

    //摇一摇后执行的
    function doResult()
    {
    	if ( yyState )
    	{
    		music();

    		//图片摇动
	        $(".shake").removeClass("animateShake");

	        setTimeout(function(){
	            $(".shake").addClass("animateShake");
	        },30);

			yyState = false;

	        //弹出弹窗
	        var popupTimer = setTimeout(function(){
	        	get_result();
	        },800);
    	}
    }

    // 开启音乐
    function music()
    {
    	var audio = document.createElement('audio');
        audio.src = 'music/5018.mp3';//这里放音乐的地址
        audio.autoplay = 'autoplay';
        document.body.appendChild(audio);
    }

    //生成弹窗
    function popup(state,imgSrc,proName)
    {
        if( state == 200 )
        {
        	//摇中
            var img = imgSrc,
            pro = '手气不错哦！<br/>获得了 ' + proName + '~',
            btn = '<a href="#" class="btn_shake" onclick="closePopup()">继续摇一摇</a>';
        }
        else if( state == -101 )
        {
        	//活动结束
            var img = 'images/sorry2.jpg',
            pro = '您晚来了一步,  该活动已经结束咯',
        	btn = '';
        }
        else if( state == -102 )
        {
        	//机会用光
            var img = 'images/sorry1.jpg',
            pro = 'Sorry,  机会用光了！<br/>分享并邀好友关注即可获得抽奖机会~',
            btn = '<a href="<?php $site ?>index.php?act=record" class="btn_see">查看兑奖记录</a><a href="javascript:;" class="btn_share" onclick="share()">立即分享</a>';
        }
        else if( state == -103 )
        {
        	//需先关注才能看到中奖记录
            var img = 'images/sorry1.jpg',
            pro = '需先关注我们，才可以看到奖品哦',
            btn = '<a href="<?php $site ?>index.php?act=share" class="btn_attention" onclick="closePopup()">去关注</a>';
        }
        else if( state == -104 )
        {
        	//不中
            var img = 'images/sorry2.jpg',
            pro = 'Sorry,  啥也没摇中！<br/>人品不够， 攒够了再来~',
        	btn = '<a href="#" class="btn_shake" onclick="closePopup()">继续摇一摇</a>';
        }

        var p_html = '<div class="popup"><div style="display:table;width:100%;height:100%;"><div style="display:table-cell;text-align:center;vertical-align:middle;"><div class="popupMain animateZoomIn"><div class="popup_img"><img src="'+ img +'"/></div><div class="popup_tips">'+ pro +'</div><div class="popup_a">'+ btn +'</div><span class="popup_close"onclick="closePopup()">关闭</span></div></div></div></div>';

        if($(".popup").length == 0)
        {
            $("body").append(p_html);
        }
    }

    //关闭弹窗
    function closePopup(){
    	//window.addEventListener('devicemotion', deviceMotionHandler, false);
        if($(".popupMain").length>0){
            $(".popupMain").removeClass("animateZoomOut");
            setTimeout(function(){
                $(".popupMain").addClass("animateZoomOut");
            },30);
            setTimeout(function(){
               $(".popup").remove();
            },400);
        }else{
            $(".popup").remove();
        }

        yyState = true;
    }

    //分享
    function share(){
        $(".popup").html('<div class="share"onclick="closePopup()"></div>');
    }

    function loadMsg()
	{
		$.ajax({
			url:'<?php echo $site; ?>api.php?act=get_activity_info',
			type:'POST',
			dataType: 'json',
			success:function(data){
				if ( data.data.enable == 0 )
				{
					popup( -101,'','活动结束');
				}
			},
			error:function(){
				alert('请求超时，请重新添加');
			}

		})
	}

	function get_result()
	{
		$.ajax({
			url:'<?php echo $site; ?>api.php?act=get_activity_result',
			type:'POST',
			dataType: 'json',
			success:function(data){
				img = '<?php echo $site?>upfiles/' + data.data.image;
				popup( data.code, img, data.data.name);		// 弹窗
			},
			error:function(){
				alert('请求超时，请重新添加');
			}

		})
	}

    //点击摇一摇
     $(function(){
         $(".shake").on("click",doResult);
     });
</script>
</body>
</html>

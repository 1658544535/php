<?php
//微信分享脚本
$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
$wxCurShareUrl = $protocol.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
$wxJsTicket = $gObjWX->getJsTicket();
$wxJsSign = $gObjWX->getJsSign($wxCurShareUrl);

$wxShareTitle = '您的宝宝会是下一个“洪荒之力”吗？';
$wxShareUrl = __CURRENT_ROOT_URL__;
$wxShareDesc = '2分钟深入了解您的宝贝各项能力发展情况';
$wxShareImg = __CURRENT_ROOT_URL__.'/share_ico.png';
?>

<script type="text/javascript" src="<?php echo $site.'js/jweixin-1.0.0.js';?>"></script>
<script type="text/javascript">
    wx.config({
        debug: false, // 开启调试模式,调用的所有api的返回值会在客户端alert出来，若要查看传入的参数，可以在pc端打开，参数信息会通过log打出，仅在pc端时才会打印。
        appId: '<?php echo $wxJsSign['appId']?>', // 必填，公众号的唯一标识
        timestamp: '<?php echo $wxJsSign['timestamp'];?>', // 必填，生成签名的时间戳
        nonceStr: '<?php echo $wxJsSign['nonceStr'];?>', // 必填，生成签名的随机串
        signature: '<?php echo $wxJsSign['signature'];?>',// 必填，签名，见附录1
        jsApiList: ['onMenuShareTimeline','onMenuShareAppMessage','scanQRCode'] // 必填，需要使用的JS接口列表，所有JS接口列表见附录2
    });
    wx.ready(function(){
        wx.onMenuShareTimeline({
            title: '<?php echo $wxShareTitle;?>', // 分享标题
            desc: '<?php echo $wxShareDesc;?>', // 分享描述
            link: '<?php echo $wxShareUrl;?>', // 分享链接
            imgUrl: '<?php echo $wxShareImg;?>', // 分享图标
            success: function () {
                // 用户确认分享后执行的回调函数
            }
        });

        wx.onMenuShareAppMessage({
            title: '<?php echo $wxShareTitle;?>', // 分享标题
            desc: '<?php echo $wxShareDesc;?>', // 分享描述
            link: '<?php echo $wxShareUrl;?>', // 分享链接
            imgUrl: '<?php echo $wxShareImg;?>', // 分享图标
            success: function () {
                // 用户确认分享后执行的回调函数
            }
        });
    });
</script>

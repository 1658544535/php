<?php include_once('header_web.php');?>
<script type="text/javascript" src="/js/jweixin-1.0.0.js"></script>
<script type="text/javascript" src="/js/wxshare.js"></script>
<script type="text/javascript">
var imgUrl = "<?php echo $site;?>images/wxLOGO.png";
var link =  "<?php echo $site;?>pdk_code_action.php?minfo=<?php echo $minfo['result']['invitationCode'];?>";
var title = "我送您一张“免单券”";
var desc  = "送您一张“免单券”，将有很多玩具等你拿。";
wxshare(false, '<?php echo $wxShareParam['appId'];?>', <?php echo $wxShareParam['timestamp'];?>, '<?php echo $wxShareParam['nonceStr'];?>', '<?php echo $wxShareParam['signature'];?>', imgUrl, link, title, desc);
</script>

<body>
    <div class="page-group" id="page-pdkFreeLink">
        <div id="page-nav-bar" class="page page-current">
            <header class="bar bar-nav">
                <a class="button button-link button-nav pull-left back" href="user.php">
                    <span class="icon icon-back"></span>
                </a>
                <a class="button button-link button-nav pull-right share" href="#">
                    <span class="icon icon-share"></span>
                </a>
                <h1 class="title">我的团免链接</h1>
            </header>

            <div class="content native-scroll">

                <section class="pdk-freeLink">
                    <img class="img" style="width:45%"  src="<?php echo $imgPath;?>" />
                    <p class="txt">分享此页面，用户通过二维码领取团免券，即可免费开团</p>
                </section>

                <section class="pdk-rule">
                    <h3 class="title1">返佣规则</h3>
                    <ul class="list">
                        <li>分享此页面给好友或朋友圈。</li>
                        <li>您的好友通过扫描您分享的二维码领取团免券，并拿此团免券进行免费开团<span class="themeColor">（注：如果您的好友帐号已经有了团免券，则不允许重复领取）</span>。</li>
                        <li>您的好友分享以上开的团，邀请其他好友参团。</li>
                        <li>如果在规定时间内拼团成功，则返佣1.5元进入您的平台帐号中。</li>
                        <li>如果在规定时间内拼团失败，至少有一位好友参团，则返佣0.3元进入您的平台帐号中。</li>
                        <li>如果在规定时间内拼团失败，且没有好友参团，则没有得到返佣奖励。</li>
                    </ul>
                </section>

            </div>
        </div>
        <div class="popup popup-share">
            <a href="#" class="close-popup"></a>
        </div>
    </div>
</body>

</html>

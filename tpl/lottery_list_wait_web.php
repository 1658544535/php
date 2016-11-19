<?php include_once('header_notice_web.php');?>
<script src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>
<script type="text/javascript" src="/js/wxshare.js"></script>
<script type="text/javascript">
    var imgUrl = "<?php echo $fx['image'];?>";
    var link   = "<?php echo $fx['url'];?>";
    var title  = "<?php echo $fx['title'];?>";
    var desc   = "<?php echo $fx['content'];?>";
    wxshare(false, '<?php echo $wxShareParam['appId'];?>', <?php echo $wxShareParam['timestamp'];?>, '<?php echo $wxShareParam['nonceStr'];?>', '<?php echo $wxShareParam['signature'];?>', imgUrl, link, title, desc);
</script>

<body>
    <div class="page-group" id="page-lottery">
        <div id="page-nav-bar" class="page page-current">
            <header class="bar bar-nav">
                <a href="index.php" class="button button-link button-nav pull-left">
                    <span class="icon icon-back"></span>
                </a>
                <a class="button button-link button-nav pull-right share">
                    <span class="icon icon-share"></span>
                </a>
                <h1 class="title">0.1夺宝</h1>
            </header>

            <nav class="bar bar-tab">
                <a href="lottery_new.php?type=1" class="tab-item tab-item2 <?php if($Type ==1){?>active<?php }?>">
                    <span class="icon i-lotterying"></span>
                    <span class="tab-label">正在进行</span>
                </a>
                <a href="lottery_new.php?type=2" class="tab-item tab-item2 <?php if($Type ==2){?>active<?php }?>">
                    <span class="icon i-lotteryed"></span>
                    <span class="tab-label">查看往期</span>
                </a>
            </nav>

            <div class="content native-scroll">
                <?php if($Type ==1){?>
                <section class="lottery-rule"><img src="<?php echo $Banner['banner'];?>" /></section>
                <?php }?>
                <section class="index-seckill pullbox infinite-scroll infinite-scroll-bottom" data-distance="30" data-href="">
					<center style="margin-top:25%;">
						<div>很多免费玩具今晚来袭～</div>
					</center>
                </section>
            </div>
        
            
        
        </div>

        <div class="popup popup-share">
            <a href="#" class="close-popup"></a>
        </div>
        <section id="goTop" class="goTop"></section>
    </div>
</body>

</html>
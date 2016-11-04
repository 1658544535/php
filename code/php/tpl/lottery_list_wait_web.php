<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title><?php echo $site_name;?></title>
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
    <script src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>
    <script type="text/javascript" src="/js/wxshare.js"></script>
    <script type="text/javascript">
        var imgUrl = "<?php echo $fx['image'];?>";
        var link   = "<?php echo $fx['url'];?>";
        var title  = "<?php echo $fx['title'];?>";
        var desc   = "<?php echo $fx['content'];?>";
        wxshare(false, '<?php echo $wxShareParam['appId'];?>', <?php echo $wxShareParam['timestamp'];?>, '<?php echo $wxShareParam['nonceStr'];?>', '<?php echo $wxShareParam['signature'];?>', imgUrl, link, title, desc);
    </script>
</head>

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
						<div>1毛夺好礼 分享新玩法</div>
						<div>11.07 重磅上线</div>
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
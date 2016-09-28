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
</head>

<body>
    <div class="page-group" id="page-deta">
        <div id="page-nav-bar" class="page page-current">

            <div class="content native-scroll" style="top:0rem;bottom:2.75rem;">

                <a href="#" class="back deta-back"></a>

                <section class="swiper-container deta-banner" data-space-between="0">
                    <div class="swiper-wrapper">
						<?php foreach($info['banners'] as $v){ ?>
							<div class="swiper-slide"><img src="<?php echo $v['bannerImage'];?>" /></div>
						<?php } ?>
                    </div>
                    <div class="swiper-pagination"></div>
                </section>

                <section class="deta-info">
                    <div class="d-i-1">
                        <span class="sales">累积销量：<?php echo $info['proSellrNum'];?>件</span>
                        ￥<span class="nowPrice"><?php echo $info['producrtPrice'];?></span>
                        <span class="oldPrice">￥<?php echo $info['alonePrice'];?></span>
                    </div>
                    <div class="name"><?php echo $info['productName'];?></div>
                    <div class="txt"><?php echo $info['title'];?></div>
                    <div class="tips"><img src="images/deta-tips.png" /></div>
                </section>
				
				<?php if(!empty($info['waitGroupList'])){ ?>
                <section class="deta-group">
                    <h3 class="title1">欢迎您直接参与其他小伙伴发起的拼团</h3>
                    <ul class="list">
						<?php foreach($info['waitGroupList'] as $_active){ ?>
						<li>
                            <a class="btn" href="groupon_join.php?id=<?php echo $_active['groupRecId'];?>&pid=<?php echo $info['productId'];?>">参团&nbsp;&gt;</a>
                            <div class="info">
                                <div class="img"><img src="<?php echo $_active['userImage'];?>" /></div>
                                <div class="name"><?php echo $_active['userName'];?></div>
                                <div class="num">还差 <?php echo $_active['oweNum'];?> 人成团</div>
                                <div class="timer" data-timer="<?php echo $_active['remainSec'];?>"><i class="icon-timer"></i><span></span> 后结束</div>
                            </div>
                        </li>
						<?php } ?>
                    </ul>
                </section>
				<?php } ?>

				<?php if($product['video_url']){ ?>
                <section class="deta-video">
                    <div class="iframeVideo"><iframe src="<?php echo $product['video_url'];?>" frameborder=0 allowfullscreen></iframe></div>
                    <!-- <video src="" poster="images/img/video-img.png" width="100%" controls="controls"></video> -->
                </section>
				<?php } ?>

                <section class="deta-img">
                    <?php echo $product['content'];?>
                </section>

                <section class="deta-tips">
                    <h3>活动说明</h3>
                    <div><img src="images/deta-tips2.png" /></div>
                </section>

            </div>

            <div class="deta-footer">
                <a class="goIndex" href="/">
                    <span class="icon i-home"></span>
                    <span class="tab-label">首页</span>
                </a>
                <div class="buy">
					<?php if($info['productStatus'] == 2){ ?>
						<a class="one">下架</a>
						<a class="more" href="/">查看更多</a>
					<?php }else{ ?>
						<a class="one" href="order_alone.php?id=<?php echo $grouponId;?>&pid=<?php echo $info['productId'];?>" id="btn-alone">
							 <p>￥<b><?php echo $info['alonePrice'];?></b></p>
							 <p>单独购买</p>
						</a>
						<?php if($info['isGroupFree']){ ?>
							<a class="more" href="order_free.php?id=<?php echo $grouponId;?>&pid=<?php echo $info['productId'];?>" id="btn-groupon">
								 <p>￥<b>0.00</b></p>
								 <p>0元开团</p>
							</a>
						<?php }else{ ?>
							<a class="more" href="order_groupon.php?id=<?php echo $grouponId;?>&pid=<?php echo $info['productId'];?>" id="btn-groupon">
								 <p>￥<b><?php echo $info['producrtPrice'];?></b></p>
								 <p><?php echo $info['groupNum'];?>人团</p>
							</a>
						<?php } ?>
					<?php } ?>
                </div>
            </div>

        </div>
    </div>
    <script type='text/javascript' src='js/zepto.js' charset='utf-8'></script>
    <script type='text/javascript' src='js/sui/sm.min.js' charset='utf-8'></script>
    <script type='text/javascript' src='js/swiper/swiper.min.js' charset='utf-8'></script>
    <script type='text/javascript' src='js/app.min.js' charset='utf-8'></script>
</body>

</html>

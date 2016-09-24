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
</head>

<body>
    <div class="page-group" id="page-index">
        <div id="page-nav-bar" class="page page-current">
            <header class="bar bar-nav">
                <h1 class="title"><img class="title-img" src="images/logo.png" alt="淘竹马" /></h1>
            </header>

            <section class="swiper-container index-class">
                <div class="swiper-wrapper">
                   <a class="swiper-slide active" data-type="index" data-href="ajaxtpl/ajax_index.php">首页</a>
                    <?php foreach ($objProductType as $type){?>
                      <a class="swiper-slide" data-type="class" data-href="ajaxtpl/ajax_index.php?tid=<?php echo $type->id;?>"><?php echo $type->name;?></a>
                    <?php }?>           
                </div>
            </section>

            <div class="content native-scroll" style="top:4.2rem;">

                <div class="swiper-container index-page">
                    <div class="swiper-wrapper">
                        <div class="swiper-slide">
                            <section class="index-pro infinite-scroll infinite-scroll-bottom" data-distance="30">
                                <!-- 加载提示符 -->
                                <div class="infinite-scroll-preloader">
                                    <div class="preloader"></div>
                                </div>
                            </section>
                        </div>
                    </div>
                </div>
            </div>

			<?php include_once('footer_nav_web.php');?>
        </div>
    </div>
<?php if($ObjUserCouPon->status ==1){?>
    <div class="popup popup-coupon">
        <div>
            <a href="#" class="close-popup"></a>
            <h3 class="title1">您有1张团免券未使用</h3>
            <div class="freeCoupon">
                <div class="info">
                    <div class="name">团长免单券 <span>(团长免费开团)</span></div>
                    <div class="tips">点击选择团免商品</div>
                    <div class="time">有效期: <?php echo $ObjUserCouPon->active_time;?>-<?php echo $ObjUserCouPon->invalid_time;?></div>
                </div>
                <div class="price"><div>￥<span>0</span></div></div>
            </div>
            <a href="groupon_free.php" class="go">立即前往</a>
        </div>
    </div>
<?php }?>
    <script type='text/javascript' src='js/zepto.js' charset='utf-8'></script>
    <script type='text/javascript' src='js/baiduTemplate.js' charset='utf-8'></script>
    <script type='text/javascript' src='js/sui/sm.min.js' charset='utf-8'></script>
    <script type='text/javascript' src='js/swiper/swiper.min.js' charset='utf-8'></script>
    <script type='text/javascript' src='js/app.min.js' charset='utf-8'></script>
</body>

</html>

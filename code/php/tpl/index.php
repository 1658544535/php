<?php include_once('header_notice_web.php');?>

<body>
    <div class="page-group" id="page-index">
        <div id="page-nav-bar" class="page page-current">
            <header class="bar bar-nav">
                <h1 class="title"><img class="title-img" src="images/logo.png" alt="淘竹马" /></h1>
            </header>
            <!-- 引入轮播部分 -->
            <?php include_once('footer_nav_web.php');?>
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
</body>

</html>

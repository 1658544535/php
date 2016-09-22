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

            <nav class="bar bar-tab">
                <a class="tab-item active" href="index_new.php">
                    <span class="icon i-home"></span>
                    <span class="tab-label">首页</span>
                </a>
                <a class="tab-item" href="product_guess_price.php">
                    <span class="icon i-price"></span>
                    <span class="tab-label">猜价格</span>
                </a>
                <a class="tab-item" href="#">
                    <span class="icon i-search"></span>
                    <span class="tab-label">搜索</span>
                </a>
                <a class="tab-item" href="#">
                    <span class="icon i-user"></span>
                    <span class="tab-label">个人中心</span>
                </a>
            </nav>

            <section class="swiper-container index-class">
                <div class="swiper-wrapper">
                    <a class="swiper-slide active" data-type="index" data-href="index_new.php">首页</a>
                    <?php foreach ($objProductType as $type){?>
                    <a class="swiper-slide" data-type="class" data-href="2"><?php echo $type->name?></a>
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
    <script type='text/javascript' src='js/zepto.js' charset='utf-8'></script>
    <script type='text/javascript' src='js/sui/sm.min.js' charset='utf-8'></script>
    <script type='text/javascript' src='js/swiper/swiper.min.js' charset='utf-8'></script>
    <script type='text/javascript' src='js/app.min.js' charset='utf-8'></script>
</body>

</html>

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
</head>

<body>
    <div class="page-group" id="page-guessList">
        <div id="page-nav-bar" class="page page-current">
            <header class="bar bar-nav">
                <a class="button button-link button-nav pull-left back" href="">
                    <span class="icon icon-back"></span>
                </a>
                <h1 class="title">猜价赢好礼</h1>
            </header>

            <nav class="bar bar-tab">
                <a class="tab-item active" href="index.html">
                    <span class="icon i-home"></span>
                    <span class="tab-label">首页</span>
                </a>
                <a class="tab-item" href="demo2.html">
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

            <div class="content native-scroll">
                <div class="guessList-banner"><img src="<?php echo $site_image ;?>focusbanner/<?php echo $ObjBanner->banner ;?>" /></div>

                <div class="freeList-tips">正在进行中</div>

                <section class="guessList pullbox infinite-scroll infinite-scroll-bottom" data-distance="30" data-href="ajaxtpl/ajax_product_guess_price.php">
                    <ul class="list-container"></ul>
                    <!-- 加载提示符 -->
                    <div class="infinite-scroll-preloader">
                        <div class="preloader"></div>
                    </div>
                </section>

            </div>

            <script id='tpl_pull' type="text/template">
                <%for(var i=0;i<data["listData"].length; i++){%>
                    <li><a href="<%=data["listData"][i]["id"]%>">
                        <div class="img"><img src="<%=data["listData"][i]["imgSrc"]%>" /></div>
                        <div class="info">
                            <div class="name"><%=data["listData"][i]["name"]%></div>
                            <div class="time">
                                <span class="btn">立即猜价</span>
                                <div class="downTime" data-timer="<%=data["listData"][i]["timer"]%>"></div>
                            </div>
                            <div class="tips">提示区间：1.00-178.00 丨 已有<span><%=data["listData"][i]["num"]%></span>人参与</div>
                        </div>
                    </a></li>
                <%}%>
            </script>

        </div>
    </div>
    
    <script type='text/javascript' src='js/zepto.js' charset='utf-8'></script>
    <script type='text/javascript' src='js/baiduTemplate.js' charset='utf-8'></script>
    <script type='text/javascript' src='js/sui/sm.min.js' charset='utf-8'></script>
    <script type='text/javascript' src='js/swiper/swiper.min.js' charset='utf-8'></script>
    <script type='text/javascript' src='js/app.min.js' charset='utf-8'></script>
</body>

</html>

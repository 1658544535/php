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
    <script type='text/javascript' src='js/zepto.js' charset='utf-8'></script>
    <script type='text/javascript' src='js/baiduTemplate.js' charset='utf-8'></script>
    <script type='text/javascript' src='js/sui/sm.min.js' charset='utf-8'></script>
    <script type='text/javascript' src='js/swiper/swiper.min.js' charset='utf-8'></script>
    <script type='text/javascript' src='js/app.min.js' charset='utf-8'></script>
</head>

<body>
    <div class="page-group" id="page-guessJoinList">
        <div id="page-nav-bar" class="page page-current">
            <header class="bar bar-nav">
                <a class="button button-link button-nav pull-left back" href="">
                    <span class="icon icon-back"></span>
                </a>
                <h1 class="title">参与用户列表</h1>
            </header>

            <nav class="bar bar-tab">
                <a class="tab-item" href="index.html">
                    <span class="icon i-home"></span>
                    <span class="tab-label">首页</span>
                </a>
                <a class="tab-item active" href="demo2.html">
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

                <div class="freeList-tips">共有<span class="themeColor"><?php echo $num['result'][0]['joinNum'];?>位</span>用户参与此活动</div>

                <div class="guessTab" data-href="ajaxtpl/ajax_product_guess_price.php?act=prize&gid=<?php echo $gId;?>">
                    <ul>
                        <li data-tip="以下用户赢得奖品" data-type="1">一等奖</li>
                        <li data-tip="以下用户获得5元抵扣券" data-type="2">二等奖</li>
                        <li data-tip="以下用户获得3元抵扣券" data-type="3">三等奖</li>
                    </ul>
                </div>

                <section class="guessJoinList clickbox" >
                    <ul class="list-container"></ul>
                    <!-- 加载提示符 -->
                    <div class="infinite-scroll-preloader">
                        <div class="preloader"></div>
                    </div>
                    <div class="bin-btn clickbtn">
                        <input type="button" value="更多">
                    </div>
                </section>

            </div>

            <script id='tpl_click' type="text/template">
                <%for(var i=0;i<data["data"].length; i++){%>
                    <li><a href="#">
                        <div class="img"><img src="<%=data["data"][i]["userImage"]%>" /></div>
                        <div class="info">
                            <div class="name"><%=data["data"][i]["userName"]%></div>
                            <div class="price"><p>出价</p><p class="themeColor">￥<span class="real"><%=data["data"][i]["userPrice"]%></span></p></div>
                            <div class="time"><%=data["data"][i]["joinTime"]%></div>
                        </div>
                    </a></li>
                <%}%>
            </script>
  <?php include_once('footer_nav_web.php');?>
        </div>
    </div>
</body>

</html>

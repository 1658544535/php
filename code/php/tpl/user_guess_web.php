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
    <div class="page-group" id="page-guess">
        <div id="page-nav-bar" class="page page-current">
            <header class="bar bar-nav">
                <a class="button button-link button-nav pull-left back" href="">
                    <span class="icon icon-back"></span>
                </a>
                <h1 class="title">我的猜价</h1>
            </header>

            <div class="content native-scroll">

                <section class="user-tab" data-href="">
                    <ul>
                        <li data-type="0"><a href="javascript:;">全部</a></li>
                        <li data-type="1"><a href="javascript:;">进行中</a></li>
                        <li data-type="2"><a href="javascript:;">未得奖</a></li>
                        <li data-type="3"><a href="javascript:;">已得奖</a></li>
                    </ul>
                </section>

                <section class="user-guess clickbox infinite-scroll infinite-scroll-bottom" data-distance="30">
                    <ul class="list-container"></ul>
                    <!-- 加载提示符 -->
                    <div class="infinite-scroll-preloader">
                        <div class="preloader"></div>
                    </div>
                </section>

            </div>

            <script id='tpl_pull_tab' type="text/template">
                <%for(var i=0;i<data["listData"].length; i++){%>
                    <li>
                        <div class="u-g-1">
                            <span class="type">拼团商品</span>
                            <span class="state">进行中</span>
                        </div>
                        <a href="" class="u-g-2">
                            <div class="img"><img src="" /></div>
                            <div class="info">
                                <div class="name">优彼思维训练机优比早教机学习机逻辑故事平板电脑幼儿童点读机</div>
                                <div class="price">
                                    <span>价格区间：<font class="themeColor">￥9.9-39.9</font></span>
                                    <span class="price2">我的猜价：<font class="themeColor">￥19.9</font></span>
                                </div>
                            </div>
                        </a>
                        <div class="u-g-3">
                            <a href="#">查看详情</a>
                        </div>
                    </li>
                <%}%>
            </script>

        </div>
    </div>
</body>

</html>

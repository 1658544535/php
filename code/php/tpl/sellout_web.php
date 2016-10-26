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
	<?php include_once('wxshare_web.php');?>
</head>

<body>
    <div class="page-group" id="page-seckill-out">
        <div id="page-nav-bar" class="page page-current">
            <header class="bar bar-nav">
                <a class="button button-link button-nav pull-left back" href="">
                    <span class="icon icon-back"></span>
                </a>
                <h1 class="title">售罄商品</h1>
            </header>

            <div class="content native-scroll">
                <section class="index-seckill pullbox infinite-scroll infinite-scroll-bottom" data-distance="30" data-href="api_action.php?act=sellout">
                    <ul class="list-container"></ul>
                    <!-- 加载提示符 -->
                    <div class="infinite-scroll-preloader">
                        <div class="preloader"></div>
                    </div>
                </section>
            </div>

            <script id='tpl_pull' type="text/template">
                <%if(data["data"].length>0){%>
                    <%for(var i=0;i<data["data"].length; i++){%>
                        <li><a href="groupon.php?id=<%=data["data"][i].activityId%>&pid=<%=data["data"][i].productId%>">
                            <div class="img"><img src="<%=data["data"][i].productImage%>" /></div>
                            <div class="info">
                                <div class="name"><%=data["data"][i].productName%></div>
                                <div class="price">
                                    <span class="price1">￥<%=data["data"][i].productPrice%></span>
                                    <span class="price2">￥<%=data["data"][i].alonePrice%></span>
                                </div>
                                <div class="btn">
                                    <span class="gray">已售罄</span>
                                </div>
                            </div>
                        </a></li>
                    <%}%>
                <%}else if(data["pageNow"] == 1){%>
                    <div class="seckill-null"></div>
                <%}%>
            </script>
        </div>
    </div>
</body>

</html>

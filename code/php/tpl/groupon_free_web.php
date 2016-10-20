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
</head>

<body>
    <div class="page-group" id="page-freeList">
        <div id="page-nav-bar" class="page page-current">
            <header class="bar bar-nav">
                <a class="button button-link button-nav pull-left back" href="javascript:history.back(-1);">
                    <span class="icon icon-back"></span>
                </a>
                <h1 class="title">团免列表</h1>
            </header>

            <?php include_once('footer_nav_web.php');?>

            <div class="content native-scroll">
                <div class="freeList-tips">选择一个商品免费开团，成团后可收货</div>

                <section class="freeList pullbox infinite-scroll infinite-scroll-bottom" data-distance="30" data-href="api_action.php?act=groupon_free">
                    <ul class="list-container"></ul>
                    <!-- 加载提示符 -->
                    <div class="infinite-scroll-preloader">
                        <div class="preloader"></div>
                    </div>
                </section>
            </div>

            <script id='tpl_pull' type="text/template">
                <%for(var i=0;i<data["data"].length; i++){%>
                    <li><a href="groupon.php?id=<%=data["data"][i].activityId%>">
                        <div class="img"><img src="<%=data["data"][i].productImage%>" /></div>
                            <div class="info">
                                <div class="name"><%=data["data"][i].productName%></div>
                                <div class="price">
                                <div class="btn">免费开团</div>
                                ￥<span class="price1">0</span>/件
                                <span class="price2">拼团价：￥<%=data["data"][i].productPrice%></span>
                            </div>
                        </div>
                    </a></li>
                <%}%>
            </script>

        </div>
        <section id="goTop" class="goTop"></section>
    </div>

</body>

</html>

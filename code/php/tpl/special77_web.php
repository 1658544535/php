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
    <div class="page-group" id="page-special-list">
        <div id="page-nav-bar" class="page page-current">
            <header class="bar bar-nav">
                <a class="button button-link button-nav pull-left back" href="">
                    <span class="icon icon-back"></span>
                </a>
                <a class="button button-link button-nav pull-right share" href="#">
                    <span class="icon icon-share"></span>
                </a>
                <h1 class="title">7.7特卖区</h1>
            </header>

            <?php include_once('footer_nav_3ge_web.php');?>

            <div class="content native-scroll">

                <section class="special-banner">
                    <img src="images/img/banner.jpg" />
                </section>

                <section class="index-pro pullbox infinite-scroll infinite-scroll-bottom" data-distance="30" data-href="">
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
                        <li><a href="groupon.php?id=<%=data["data"][i].activityId%>">
                            <div class="img"><img src="<%=data["data"][i]["productImage"]%>" /></div>
                            <div class="name">
                                <span class="num"><%=data["data"][i]["groupNum"]%>人团</span><%=data["data"][i]["productName"]%>
                            </div>
                            <div class="info">
                                ￥<span class="price"><%=data["data"][i]["productPrice"]%></span>
                                <span class="sales">已团<%=data["data"][i]["proSellrNum"]%>件</span>
                            </div>
                        </a></li>
                    <%}%>
                <%}else if(data["pageNow"] == 1){%>
                    <div class="tips-null">没有更多商品</div>
                <%}%>
            </script>

        </div>
        <div class="popup popup-share">
            <a href="#" class="close-popup"></a>
        </div>
    </div>
</body>

</html>

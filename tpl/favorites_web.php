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
    <div class="page-group" id="page-collection">
        <div id="page-nav-bar" class="page page-current">
            <header class="bar bar-nav">
                <a class="button button-link button-nav pull-left back" href="javascript:history.back(-1);">
                    <span class="icon icon-back"></span>
                </a>
                <h1 class="title">我的收藏</h1>
            </header>
           <?php include_once('footer_nav_web.php');?>
            <div class="content native-scroll">

                <section class="user-collection pullbox infinite-scroll infinite-scroll-bottom" data-distance="30" data-href="ajaxtpl/ajax_product_collect.php">
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
                    <li>
                        <a href="#" class="img"><img src="<%=data["data"][i]["productImage"]%>" /></a>
                        <div class="info">
                            <a href="#" class="name"><%=data["data"][i]["productName"]%></a>
                            <div class="option">
                                <a href="#" class="group">
                                    <%=data["data"][i]["groupNum"]%>人团&nbsp;&nbsp;<font class="themeColor">￥<span class="price"><%=data["data"][i]["productPrice"]%></span></font>
                                    <span class="btn">去开团&nbsp;&gt;</span>
                                </a>
                                <a href="javascript:;" class="collecting"></a>
                            </div>
                        </div>
                    </li>
                <%}%>
            <%}else{%>
                <div class="tips-null">暂无收藏</div>
            <%}%>
            </script>

        </div>
    </div>
</body>

</html>

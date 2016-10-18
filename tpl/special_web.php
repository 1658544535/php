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
                <a class="button button-link button-nav pull-left back" href="specials.php">
                    <span class="icon icon-back"></span>
                </a>
                <a class="button button-link button-nav pull-right share" href="javascript:;">
                    <span class="icon icon-share"></span>
                </a>
                <h1 class="title"><?php echo $pic['specialName'];?></h1>
            </header>

            <?php include_once('footer_nav_web.php');?>

            <div class="content native-scroll">

                <section class="special-banner">
                    <img src="<?php echo $pic['image'];?>" />
                </section>

<!--
                <section class="special-downTime">
                    <div class="title1"><span>活动剩余时间</span></div>
                    <div id="downtime" class="downtime" data-timer="400"><span>0</span><span>0</span>:<span>0</span><span>0</span>:<span>0</span><span>0</span></div>
                </section>
-->


                <section class="index-pro pullbox infinite-scroll infinite-scroll-bottom" data-distance="30" data-href="api_action.php?act=special&id=<?php echo $id;?>">
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
                                <span class="num"><%=data["data"][i]["grouponNum"]%>人团</span><%=data["data"][i]["productName"]%>
                            </div>
                            <div class="info">
                                ￥<span class="price"><%=data["data"][i]["price"]%></span>
                                <span class="sales">已团<%=data["data"][i]["grouponNum"]%>件</span>
                            </div>
                        </a></li>
                    <%}%>
                <%}else if(data["pageNow"] == 1){%>
                    <div class="tips-null">没有更多商品</div>
                <%}%>
            </script>

        </div>
        <div class="popup popup-share">
            <a href="javascript:;" class="close-popup"></a>
        </div>
    </div>
</body>

</html>

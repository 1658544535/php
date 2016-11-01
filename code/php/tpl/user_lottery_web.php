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
    <div class="page-group" id="page-myLottery">
        <div id="page-nav-bar" class="page page-current">
            <header class="bar bar-nav">
                <a class="button button-link button-nav pull-left back" href="user.php">
                    <span class="icon icon-back"></span>
                </a>
                <h1 class="title">我的抽奖</h1>
            </header>

            <div class="content native-scroll">

                <section class="user-guess pullbox infinite-scroll infinite-scroll-bottom" data-distance="30" data-href="ajaxtpl/ajax_user_lottery.php?uid=<?php echo $userid;?>">
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
                            <div class="u-g-1">
                                <span class="type">拼团商品</span>
                               <%if(data["data"][i]["orderStatus"] ==1){%>
                                <span class="state">待支付</span>
                               <%}else if(data["data"][i]["orderStatus"] ==2){%>                            
                                <span class="state">拼团中，差<%=data["data"][i]["poorNum"]%>人</span>                           	   
                               <%}else if(data["data"][i]["orderStatus"] ==3){%>
                                <span class="state">未成团，退款中</span> 							   
                               <%}else if(data["data"][i]["orderStatus"] ==4){%>
                                <span class="state">未成团，已退款</span>                               
                               <%}else if(data["data"][i]["orderStatus"] ==5){%>
                                <span class="state">交易已取消</span>                               
                               <%}else if(data["data"][i]["orderStatus"] ==6){%>
                                <span class="state">未中奖，待返款</span>                               
                               <%}else if(data["data"][i]["orderStatus"] ==7){%>
                                <span class="state">未中奖，已返款</span>                               
                               <%}else if(data["data"][i]["orderStatus"] ==8){%>
                                <span class="state">已成团，待开奖</span>                               
                               <%}else if(data["data"][i]["orderStatus"] ==9){%>
                                <span class="state">已中奖，已完成</span>                               
                               <%}else if(data["data"][i]["orderStatus"] ==10){%>
                                <span class="state">已中奖，待发货</span>                               
                               <%}else if(data["data"][i]["orderStatus"] ==11){%>
                                <span class="state">已中奖，待收货</span>                               
                               <%}%>                            
                            </div>
                            <a href="order_detail.php?oid=<%=data["data"][i]["orderId"]%>" class="u-g-2">
                                <div class="img"><img src="<%=data["data"][i]["productImage"]%>" /></div>
                                <div class="info">
                                    <div class="name"><%=data["data"][i]["productName"]%></div>
                                    <div class="price">
                                        <div class="price3">实付：<span>￥<%=data["data"][i]["productPrice"]%></span>（免运费）</div>
                                    </div>
                                    <div class="num">x1</div>
                                </div>
                            </a>
                            <div class="u-g-3">
                                <%if(data["data"][i]["isShow"] ==1){%>
                                 <a class="gray" href="lottery_new.php?act=comment&proimage=<%=data["data"][i]["productImage"]%>&proname=<%=data["data"][i]["productName"]%>&attid=<%=data["data"][i]["attendId"]%>">我要晒图</a>
                                <%}%>
                                <%if(data["data"][i]["isPrize"] ==1){%>
                                 <a href="lottery_new.php?act=winning&aid=<%=data["data"][i]["activityId"]%>">中奖信息</a>
                                <%}%>
                            </div>
                        </li>
                    <%}%>
                <%}else if(data["pageNow"] == 1){%>
                    <div class="tips-null">暂无抽奖</div>
                <%}%>
            </script>

        </div>
        <section id="goTop" class="goTop"></section>
    </div>
</body>

</html>

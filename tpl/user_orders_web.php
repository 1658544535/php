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
    <div class="page-group" id="page-orderList">
        <div id="page-nav-bar" class="page page-current">
            <header class="bar bar-nav">
                <a class="button button-link button-nav pull-left back" href="">
                    <span class="icon icon-back"></span>
                </a>
                <h1 class="title">我的订单</h1>
            </header>

            <div class="content native-scroll">

                <section class="user-tab user-tab6" data-href="ajaxtpl/ajax_user_orders.php">
                    <ul>
                        <li data-type="0"><a href="javascript:;">全部</a></li>
                        <li data-type="1"><a href="javascript:;">待付款</a></li>
                        <li data-type="2"><a href="javascript:;">拼团中</a></li>
                        <li data-type="3"><a href="javascript:;">待发货</a></li>
                        <li data-type="3"><a href="javascript:;">待收货</a></li>
                        <li data-type="3"><a href="javascript:;">待评价</a></li>
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
            <%if(data["data"].length>0){%>
                <%for(var i=0;i<data["data"].length; i++){%>
                    <li>
                        <div class="u-g-1">
                            <span class="type">拼团商品</span>
                             <span class="state">
                               <%if(data["data"][i].orderStatus ==1){%>                                  
                                                                           待支付
                               <%}else if(data["data"][i].orderStatus ==2){%>
                                                                           已成团，待发货
                               <%}else if(data["data"][i].orderStatus ==3){%>    
                                                                            待收货 
                               <%}else if(data["data"][i].orderStatus ==5){%>
                                                                             已完成                               
                               <%}else if(data["data"][i].orderStatus ==6){%>
                                                                             拼团中，还差<%=data["data"][i]["oweNum"]%>人
                               <%}%>
                             </span>
                        </div>
                        <a href="order_detail.php?oid=<%=data["data"][i]["orderId"]%>" class="u-g-2">
                            <div class="img"><img src="<%=data["data"][i]["productImage"]%>" /></div>
                            <div class="info">
                                <div class="name"><%=data["data"][i]["productName"]%></div>
                                <div class="price">
                                    <div class="price3">实付：<span>￥<%=data["data"][i]["orderPrice"]%></span>（免运费）</div>
                                </div>
                            </div>
                        </a>
                        <div class="u-g-3">
                           <%if(data["data"][i].orderStatus ==1){%>  
                            <a class="gray" href="#">取消</a>
                            <a href="#">去支付</a>
                           <%}else if(data["data"][i].orderStatus ==2){%>
                            <a class="gray" href="#">延长收货</a>
                            <a class="gray" href="user_logistics.php?oid=<%=data["data"][i]["id"]%>">查看物流</a>
                            <a href="#">确认收货</a>
                           <%}else if(data["data"][i].orderStatus ==3){%>
                            <a href="aftersale.php?act=apply&oid=<%=data["data"][i]["id"]%>">申请退款</a>
                           <%}else if(data["data"][i].orderStatus ==5){%>
                            <a class="gray" href="#">查看物流</a>
                            <a href="#">立即评价</a>
                           <%}else if(data["data"][i].orderStatus ==6){%> 
                            <a class="gray" href="#">查看</a>
                            <a href="#">邀请好友拼团</a>
                           <%}%>                        
                       </div>
                    </li>
                <%}%>
            <%}else{%>
                <li class="null"></li>
            <%}%>
            </script>

        </div>
    </div>
</body>

</html>

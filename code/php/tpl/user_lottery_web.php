<?php include_once('header_web.php');?>
<body>
    <div class="page-group" id="page-myLottery">
        <div id="page-nav-bar" class="page page-current">
            <header class="bar bar-nav">
                <a class="button button-link button-nav pull-left back" href="user.php">
                    <span class="icon icon-back"></span>
                </a>
                <h1 class="title">我的抽奖</h1>
            </header>

            <section class="user-tab lottery-tab" data-href="ajaxtpl/ajax_user_lottery.php" style="position:absolute;width: 100%;bottom:0;">
                <ul>
                    <li data-type="1"><a href="/user_lottery.php?type=1">0.1夺宝</a></li>
                    <li data-type="2"><a href="/user_lottery.php?type=2">免费抽奖</a></li>
                </ul>
            </section>

            <div class="content native-scroll" style="bottom: 40px;">

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
                               <%}else if(data["data"][i]["orderStatus"] ==9){%>
                                <span class="state">已中奖，已完成</span>                               
                               <%}else if(data["data"][i]["orderStatus"] ==10){%>
                                <span class="state">已中奖，待发货</span>                               
                               <%}else if(data["data"][i]["orderStatus"] ==11){%>
                                <span class="state">已中奖，待收货</span>   
                               <%}else if(data["data"][i]["orderStatus"] ==12){%>
                                <span class="state">已成团，待开奖</span>                                 
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
                                <%if(data["data"][i]["isShow"] ==1 && data["data"][i]["orderStatus"] ==9 ){%>
                                  <%if(type ==1){%>
                                   <a class="gray" href="lottery_new.php?act=comment&attId=<%=data["data"][i]["attendId"]%>&aid=<%=data["data"][i]["activityId"]%>&proimage=<%=data["data"][i]["productImage"]%>&proname=<%=data["data"][i]["productName"]%>">我要晒图</a>
                                  <%}}%>
                                <%if(data["data"][i]["isPrize"] ==1 && ((data["data"][i]["orderStatus"] ==3) || (data["data"][i]["orderStatus"] ==4) || (data["data"][i]["orderStatus"] ==6)||　(data["data"][i]["orderStatus"] ==7) || (data["data"][i]["orderStatus"] ==9) || (data["data"][i]["orderStatus"] ==10) || (data["data"][i]["orderStatus"] ==11))){%>
                                  <%if(type==1){%>
                                    <a href="lottery_new.php?act=winning&attId=<%=data["data"][i]["attendId"]%>&type=5">中奖信息</a>
                                  <%}else{%>
                                    <a href="lottery_new.php?act=winning&attId=<%=data["data"][i]["attendId"]%>&type=7">中奖信息</a>
                                <%}}%>
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

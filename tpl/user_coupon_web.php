<?php include_once('header_web.php');?>
<?php include_once('wxshare_web.php');?>
<body>
    <div class="page-group" id="page-coupon">
        <div id="page-nav-bar" class="page page-current">
            <header class="bar bar-nav">
                <a class="button button-link button-nav pull-left back" href="javascript:history.back(-1);">
                    <span class="icon icon-back"></span>
                </a>
                <h1 class="title">优惠券</h1>
            </header>

            <div class="content native-scroll">

                <section class="user-tab user-tab3" data-href="ajaxtpl/ajax_user_coupon_new.php">
                    <ul>
                        <li data-type="1"><a href="javascript:;">未使用（<?php echo $coupon['result']['notUsedNum'] ;?>）</a></li>
                        <li data-type="2"><a href="javascript:;">已过期（<?php echo $coupon['result']['overdueNum'];?>）</a></li>
                        <li data-type="3"><a href="javascript:;">已使用（<?php echo $coupon['result']['usedNum']; ?>）</a></li>
                    </ul>
                </section>

                <section class="user-coupon clickbox infinite-scroll infinite-scroll-bottom" data-distance="30">
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
						<%if(data["data"][i]["used"]==0 &&　data["data"][i]["overdue"]==0){%>
                        <div class="freeCoupon ">
						<%}else{%>
                        <div class="freeCoupon invalid">
						<%}%>
                            <div class="info">
                                <div class="name">折扣券</div>
                                <%if(data["data"][i]["isProduct"] ==1 && data["data"][i]["couponType"] ==2){%>
                                <a href="groupon.php?id=<%=data["data"][i]["activityId"]%>">                                
                                <div class="tips">购买指定商品直减<%=data["data"][i]["m"]%>元</div>
                                </a>
                                <%}else if(data["data"][i]["isProduct"] ==1 && data["data"][i]["couponType"] ==1){%>
                                <a href="groupon.php?id=<%=data["data"][i]["activityId"]%>">
                                <div class="tips">购买指定商品满<%=data["data"][i]["om"]%>减<%=data["data"][i]["m"]%>元</div>
                                </a>
                                <%}else if(data["data"][i]["isProduct"] ==0 && data["data"][i]["couponType"] ==2){%>
                                <a href="index.php">                                
                                <div class="tips">全场商品直减<%=data["data"][i]["m"]%>元</div>
                                </a>
                                <%}else if(data["data"][i]["isProduct"] ==0 && data["data"][i]["couponType"] ==1){%>
                                <a href="index.php">                                
                                <div class="tips">全场商品满<%=data["data"][i]["om"]%>减<%=data["data"][i]["m"]%>元</div>
                                </a>                                
                                <%}%>
                                <div class="time">有效期: <%=data["data"][i]["validStime"]%>-<%=data["data"][i]["validEtime"]%></div>
                            </div>
                            <div class="price"><div>￥<span><%=data["data"][i]["m"]%></span></div></div>

							<%if(data["data"][i]["overdue"]==1　&& data["data"][i]["used"]==0){%>
                        	<div class="overdue"><!--已过期--></div>
                            <%}else if(data["data"][i]["used"]==1 ){%>
                            <div class="used"><!--已使用--></div>
                            <%}%>
                        </div>
                    </li>
                <%}%>
            <%}else if(data["pageNow"]==1){%>
                <li class="null"></li>
            <%}%>
            </script>

        </div>
    </div>
</body>

</html>

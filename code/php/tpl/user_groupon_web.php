<?php include_once('header_web.php');?>
<?php include_once('wxshare_web.php');?>

<body>
    <div class="page-group" id="page-myGroup">
        <div id="page-nav-bar" class="page page-current">
            <header class="bar bar-nav">
                <a class="button button-link button-nav pull-left back" href="user.php">
                    <span class="icon icon-back"></span>
                </a>
                <h1 class="title">我的团</h1>
            </header>

            <div class="content native-scroll">

                <section class="user-tab user-tab4" data-href="api_action.php?act=user_groupon">
                    <ul>
                        <li data-type="0"><a href="user_info.php?act=groupon&type=0">全部</a></li>
                        <li data-type="1"><a href="user_info.php?act=groupon&type=1">拼团中</a></li>
                        <li data-type="2"><a href="user_info.php?act=groupon&type=2">已成团</a></li>
                        <li data-type="3"><a href="user_info.php?act=groupon&type=3">拼团失败</a></li>
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
								<%if(data["data"][i].activityStatus == 1){%>
									拼团中
								<%}else if(data["data"][i].activityStatus == 2){%>
									拼团成功
								<%}else if(data["data"][i].activityStatus == 3){%>
									拼团失败
								<%}%>
							</span>
                        </div>
                        <a href="groupon.php?id=<%=data["data"][i].activityId%>" class="u-g-2">
                            <div class="img"><img src="<%=data["data"][i].productImage%>" /></div>
                            <div class="info">
                                <div class="name"><%=data["data"][i].productName%></div>
                                <div class="price">
                                    <div class="price3"><%=data["data"][i].groupNum%>人团：<span>￥<%=data["data"][i].alonePrice%></span></div>
                                </div>
                            </div>
                        </a>
                        <div class="u-g-3">
							<%if(data["data"][i].activityStatus == 1){%>
								<a class="gray" href="groupon_join.php?aid=<%=data["data"][i].groupRecId%>">邀请好友拼团</a>
							<%}else{%>
								<a class="gray" href="groupon_join.php?aid=<%=data["data"][i].groupRecId%>">查看团详情</a>
							<%}%>
                            <a href="order_detail.php?oid=<%=data["data"][i].orderId%>">查看订单详情</a>
                        </div>
                    </li>
                <%}%>
            <%}else if(data["pageNow"] == 1){%>
                <div class="tips-null">没有更多拼团</div>
            <%}%>
            </script>

        </div>
        <section id="goTop" class="goTop"></section>
    </div>
</body>

</html>

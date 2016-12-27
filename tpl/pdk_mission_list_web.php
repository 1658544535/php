<?php include_once('header_notice_web.php');?>

<body>
    <div class="page-group" id="page-taskList">
        <div id="page-nav-bar" class="page page-current">
            <header class="bar bar-nav">
                <a href="user.php" class="button button-link button-nav pull-left">
                    <span class="icon icon-back"></span>
                </a>
                <h1 class="title">拼得好</h1>
            </header>

            <div class="content native-scroll">
                <section class="index-seckill pullbox infinite-scroll infinite-scroll-bottom" data-distance="30" data-href="ajaxtpl/ajax_pdk_mission.php">
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
                         <a href="groupon.php?id=<%=data["data"][i]["activityId"]%>">
                           <div class="img"><img src="<%=data["data"][i]["productImage"]%>" /></div>
                            <div class="info">
                                <div class="name"><span class="num"><%=data["data"][i]["groupNum"]%>人团</span><%=data["data"][i]["productName"]%></div>
                                <div class="price">
                                    <span class="price1">￥<%=data["data"][i]["productPrice"]%></span>
                                    <span class="price2">￥<%=data["data"][i]["alonePrice"]%></span>
                                </div>
                                <div class="btn">
                                    <span class="red">领取任务</span>
                                </div>
                            </div>
                        </a></li>
                    <%}%>
                <%}else if(data["pageNow"] == 1){%>
                    <div class="list-null">暂无任务</div>
                <%}%>
            </script>
        
        </div>
    </div>
</body>

</html>
<?php include_once('header_notice_web.php');?>
<?php include_once('wxshare_web.php');?>
<style type="text/css">
.cut-groupon-num{margin-right: .25rem; padding: 0 .15rem; text-align: justify; font-size: .5rem; color: #f85981; border: 1px solid #f85981; border-radius: 3px;}
</style>

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
                                <div class="name"><span class="cut-groupon-num"><%=data["data"][i].groupNum%>人团</span><%=data["data"][i].productName%></div>
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

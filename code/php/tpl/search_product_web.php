<?php include_once('header_notice_web.php');?>
<?php include_once('wxshare_web.php');?>

<body>
    <div class="page-group" id="page-search">
        <div id="page-nav-bar" class="page page-current">
            <header class="bar bar-nav">
                <a class="button button-link button-nav pull-left back" href="javascript:history.back(-1);">
                    <span class="icon icon-back"></span>
                </a>
                <a class="button button-link button-nav pull-right search" onclick="$('#searchForm').submit()">搜索</a>
                <div class="bar-search">
                    <form id="searchForm" action="search_product.php">
                        <div class="txt"><input type="text" name="name" value="<?php echo $name;?>" placeholder="搜索商品" /></div>
                        <span class="clearTxt"></span>
                    </form>
                </div>
            </header>
            <?php include_once('footer_nav_web.php');?>

            

            <div class="content native-scroll">
             <?php if($search['result']['count'] !=''){?>
                <div class="searchTips">共找到<span id="searchNum"><?php echo $search['result']['count']?></span>条相关结果</div>
             <?php }?>
                <section class="index-pro pullbox infinite-scroll infinite-scroll-bottom" data-distance="30" data-href="ajaxtpl/ajax_search.php?name=<?php echo $name ;?>">
                    <ul class="list-container"></ul>
                    <!-- 加载提示符 -->
                    <div class="infinite-scroll-preloader">
                        <div class="preloader"></div>
                    </div>
                </section>

            </div>

            <script id='tpl_pull' type="text/template">
            <%if(!!data["data"]){%>
                <%for(var i=0;i<data["data"].length; i++){%>
                    <li><a href="groupon.php?id=<%=data["data"][i]["activityId"]%>">
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
                <div class="tips-null">暂无商品</div>
            <%}%>
            </script>
            
        </div>
        <section id="goTop" class="goTop"></section>
    </div>
</body>

</html>
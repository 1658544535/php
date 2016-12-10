<?php include_once('header_notice_web.php');?>
<script src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>
<script type="text/javascript" src="/js/wxshare.js"></script>
<script type="text/javascript">
var imgUrl = "<?php echo $fx['image'];?>";
var link   = "<?php echo $fx['url'];?>";
var title  = "<?php echo $fx['title'];?>";
var desc   = "<?php echo $fx['content'];?>";
wxshare(false, '<?php echo $wxShareParam['appId'];?>', <?php echo $wxShareParam['timestamp'];?>, '<?php echo $wxShareParam['nonceStr'];?>', '<?php echo $wxShareParam['signature'];?>', imgUrl, link, title,desc);
</script>

<body>
    <div class="page-group" id="page-guessList">
        <div id="page-nav-bar" class="page page-current">
            <header class="bar bar-nav">
                <a class="button button-link button-nav pull-left back" href="javascript:history.back(-1);">
                    <span class="icon icon-back"></span>
                </a>
                <h1 class="title">猜价赢好礼</h1>
            </header>
            <nav class="bar bar-tab">
                <a href="product_guess_price.php" class="tab-item tab-item2 active">
                    <span class="icon i-lotterying"></span>
                    <span class="tab-label">进行中</span>
                </a>
                <a href="product_guess_before_price.php" class="tab-item">
                    <span class="icon i-lotteryed"></span>
                    <span class="tab-label">查看往期</span>
                </a>
            </nav>



            <div class="content native-scroll">

                <div class="guessList-banner"><img src="<?php echo $ObjBanner['result']['banner'] ;?>" style="width:100%;" /></div>

                <div class="freeList-tips">正在进行中<span id="rule" class="f-right">活动规则</span></div>

                <section class="guessList pullbox infinite-scroll infinite-scroll-bottom" data-distance="30" data-href="ajaxtpl/ajax_product_guess_price.php">
                    <ul class="list-container"></ul>
                    <!-- 加载提示符 -->
                    <div class="infinite-scroll-preloader">
                        <div class="preloader"></div>
                    </div>
                </section>

            </div>

           <script id='tpl_pull' type="text/template">
            <%if(data["proData"]["listData"]["data"].length>0){%>
                <%for(var i=0;i<data["proData"]["listData"]["data"].length; i++){%>
                    <li><a href="product_guess_price.php?act=detail&gid=<%=data["proData"]["listData"]["data"][i]["activityId"]%>&pid=<%=data["proData"]["listData"]["data"][i]["productId"]%>">
                        <div class="img"><img src="<%=data["proData"]["listData"]["data"][i]["productImage"]%>" /></div>
                        <div class="info">
                            <div class="name"><%=data["proData"]["listData"]["data"][i]["productName"]%></div>
                            <div class="time">
                                <span class="btn">立即猜价</span>
                                <div class="downTime" data-timer="<%=data["proData"]["listData"]["TimeDiff"][i]%>"></div>
                            </div>
                            <div class="tips">提示区间：<%=data["proData"]["listData"]["data"][i]["minPrice"]%>-<%=data["proData"]["listData"]["data"][i]["maxPrice"]%> 丨 已有<span><%=data["proData"]["listData"]["data"][i]["joinNum"]%></span>人参与</div>
                        </div>
                    </a></li>
                <%}%>
            <%}else if(data["proData"]["pageNow"] == 1){%>
                <div class="tips-null">品类齐聚  新品来袭<br/>猜价好礼  静候良机</div>
            <%}%>
            </script>
        </div>

        <div class="popup popup-rule">
            <img src="images/guess-rule.png" />
            <a href="#" class="close-popup"></a>
        </div>
        <section id="goTop" class="goTop"></section>
    </div>

</body>

</html>

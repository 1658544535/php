<?php include_once('header_notice_web.php');?>
<script src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>
<script type="text/javascript" src="/js/wxshare.js"></script>
<script type="text/javascript">
var imgUrl = "<?php echo $fx['image'];?>";
var link   = "<?php echo $fx['url'];?>";
var title  = "<?php echo $fx['title'];?>";
var desc   = "<?php echo $fx['content'];?>";
wxshare(false, '<?php echo $wxShareParam['appId'];?>', <?php echo $wxShareParam['timestamp'];?>, '<?php echo $wxShareParam['nonceStr'];?>', '<?php echo $wxShareParam['signature'];?>', imgUrl,link,title,desc);
</script>

<body>
    <div class="page-group" id="page-special-list">
        <div id="page-nav-bar" class="page page-current">
            <header class="bar bar-nav">
                <a class="button button-link button-nav pull-left back" href="javascript:history.back(-1);">
                    <span class="icon icon-back"></span>
                </a>
                <a class="button button-link button-nav pull-right share" href="javascript:;">
                    <span class="icon icon-share"></span>
                </a>
                <h1 class="title"><?php echo $SpecialImage['specialName'];?></h1>
            </header>

            <?php include_once('footer_nav_web.php');?>

            <div class="content native-scroll">

                <section class="special-banner">
                    <img src="<?php echo $SpecialImage['image'];?>" />
                </section>

<!--
                <section class="special-downTime">
                    <div class="title1"><span>活动剩余时间</span></div>
                    <div id="downtime" class="downtime" data-timer="400"><span>0</span><span>0</span>:<span>0</span><span>0</span>:<span>0</span><span>0</span></div>
                </section>
-->


                <section class="index-pro pullbox infinite-scroll infinite-scroll-bottom" data-distance="30" data-href="api_action.php?act=newspecial">
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
                                <span class="num"><%=data["data"][i]["num"]%>人团</span><%=data["data"][i]["productName"]%>
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
        <section id="goTop" class="goTop"></section>
    </div>
</body>

</html>

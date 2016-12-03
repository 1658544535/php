<?php include_once('header_notice_web.php');?>
<script src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>
<script type="text/javascript" src="/js/wxshare.js"></script>
<script type="text/javascript">
    var imgUrl = "<?php echo $fx['image'];?>";
    var link   = "<?php echo $fx['url'];?>";
    var title  = "<?php echo $fx['title'];?>";
    var desc   = "<?php echo $fx['content'];?>";
    wxshare(false, '<?php echo $wxShareParam['appId'];?>', <?php echo $wxShareParam['timestamp'];?>, '<?php echo $wxShareParam['nonceStr'];?>', '<?php echo $wxShareParam['signature'];?>', imgUrl, link, title, desc);
</script>

<body>
    <div class="page-group" id="page-lottery">
        <div id="page-nav-bar" class="page page-current">
            <header class="bar bar-nav">
                <a href="index.php" class="button button-link button-nav pull-left">
                    <span class="icon icon-back"></span>
                </a>
                <a class="button button-link button-nav pull-right share">
                    <span class="icon icon-share"></span>
                </a>
                <h1 class="title">免费试用</h1>
            </header>

            <!-- 底部导航 -->
            <nav class="bar bar-tab">
                <a href="freedraw.php?type=1" class="tab-item tab-item2 <?php if($Type ==1){?>active<?php }?>">
                    <span class="icon i-lotterying"></span>
                    <span class="tab-label">正在进行</span>
                </a>
                <a href="freedraw.php?type=2" class="tab-item tab-item2 <?php if($Type ==2){?>active<?php }?>">
                    <span class="icon i-lotteryed"></span>
                    <span class="tab-label">查看往期</span>
                </a>
            </nav>

            <div class="content native-scroll">
                <?php if($Type == 1){?>
                <section class="guessList-banner"><img src="<?php echo $Banner['banner'];?>" /></section>
                <div class="freeList-tips">正在进行中<span id="rule" class="f-right">活动规则</span></div>
                <style>.freeDraw-null{margin:10% 0;}</style>
                <?php }?>
                <section class="index-seckill pullbox infinite-scroll infinite-scroll-bottom" data-distance="30" data-href="ajaxtpl/ajax_freedraw.php?type=<?php echo $Type;?>">
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
                       <?php if($Type ==1){?>                        
                         <a href="groupon.php?id=<%=data["data"][i]["activityId"]%>">
                       <?php }else{?>     
                         <a href="lottery_new.php?act=winning&aid=<%=data["data"][i]["activityId"]%>&type=7">
                       <?php }?>
                           <div class="img"><img src="<%=data["data"][i]["productImage"]%>" /></div>
                            <div class="info">
                                <div class="name"><span class="num"><%=data["data"][i]["groupNum"]%>人团</span><%=data["data"][i]["productName"]%></div>
                                <div class="price">
                                    <span class="price1">￥<%=data["data"][i]["productPrice"]%></span><span class="price2">￥<%=data["data"][i]["alonePrice"]%></span>
                                </div>
                                <div class="btn">
                                <?php if($Type ==1){?>
                                    <span class="red">免费开团</span>
                                <?php }else{?>
                                    <span class="red">中奖信息</span>
                                <?php }?>
                                </div>
                            </div>
                        </a></li>
                    <%}%>
                <%}else if(data["pageNow"] == 1){%>
                    <div class="freeDraw-null"></div>
                <%}%>
            </script>
        
        </div>

        <div class="popup popup-share">
            <a href="#" class="close-popup"></a>
        </div>
        <div class="popup popup-rule">
            <img src="images/free-rule.png" />
            <a href="#" class="close-popup"></a>
        </div>
        <section id="goTop" class="goTop"></section>
    </div>
</body>

</html>
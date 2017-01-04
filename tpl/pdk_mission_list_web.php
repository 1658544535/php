<?php include_once('header_notice_web.php');?>
<script type="text/javascript" src="/js/jweixin-1.0.0.js"></script>
<script type="text/javascript" src="/js/wxshare.js"></script>
<script type="text/javascript">
var imgUrl = "<?php echo $site;?>images/200.jpg";
var link = "<?php echo $site;?>pindeke.php?act=mission";
var title ="拼得好";
var desc = "1毛夺好礼，拼享新玩法";
wxshare(false, '<?php echo $wxShareParam['appId'];?>', <?php echo $wxShareParam['timestamp'];?>, '<?php echo $wxShareParam['nonceStr'];?>', '<?php echo $wxShareParam['signature'];?>', imgUrl, link, title, desc);
</script>

<body>
    <div class="page-group" id="page-taskList">
        <div id="page-nav-bar" class="page page-current page-taskList">
            <script>
                var classJson = <?php echo json_encode($classOne);?>;
            </script>
            <header class="bar bar-nav">
                <a class="button button-link button-nav pull-left back" href="javascript:history.back(-1);">
                    <span class="icon icon-back"></span>
                </a>
                <a class="button button-link button-nav pull-right search">搜索</a>
                <div class="bar-search">
                    <div class="txt"><input id="search" type="text" name="name" value="" placeholder="搜索商品" /></div>
                </div>
            </header>
            <section class="user-tab user-tab3">
                <ul>
                    <li class="double" data-type1="1" data-type2="11"><a href="javascript:;">销量</a></li>
                    <li class="double" data-type1="2" data-type2="22"><a href="javascript:;">价格</a></li>
                    <li class="out"><a href="javascript:;">筛选</a></li>
                </ul>
            </section>

            <div class="content native-scroll" style="top: 4.2rem;">

                <section class="index-seckill pullbox infinite-scroll infinite-scroll-bottom" data-distance="30" data-href="ajaxtpl/ajax_pdk_mission.php">
                    <ul class="list-container"></ul>
                    <!-- 加载提示符 -->
                    <div class="infinite-scroll-preloader" style="display: none;">
                        <div class="preloader"></div>
                    </div>
                </section>
            </div>
        
            <script id='tpl_pull' type="text/template">
                <%if(data.length>0){%>
                    <%for(var i=0;i<data.length; i++){%>
                       <li>
                         <a href="groupon.php?id=<%=data[i]["activityId"]%>">
                           <div class="img"><img src="<%=data[i]["productImage"]%>" /></div>
                            <div class="info">
                                <div class="name"><span class="num"><%=data[i]["groupNum"]%>人团</span><%=data[i]["productName"]%></div>
                                <div class="price">
                                    <div class="price1">赚: ￥<%=data[i]["rebatePrice"]%></div>
                                    <span class="price3">￥<%=data[i]["productPrice"]%></span>
                                </div>
                                <div class="btn">
                                    <span class="red">领取任务</span>
                                </div>
                            </div>
                        </a></li>
                    <%}%>
                <%}else if(pageNow == 1){%>
                    <div class="tips-null">暂无商品</div>
                <%}%>
            </script>
        
        </div>
        <div class="popup popup-class">
            <div class="main">
                <h3 class="title1">分类</h3>
                <div class="info">
                    <div class="item"><input id="class1" type="text" placeholder="一级分类"  readonly="readonly" /></div>
                    <div class="item"><input id="class2" type="text" placeholder="二级分类"  readonly="readonly" /></div>
                    <div class="item"><input id="class3" type="text" placeholder="三级分类"  readonly="readonly" /></div>
                </div>
                <div class="btn">
                    <a class="gray close-popup" href="javascript:;">取消</a>
                    <a id="screen" class="close-popup" href="javascript:;">确定</a>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
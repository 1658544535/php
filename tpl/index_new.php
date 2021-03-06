<?php include_once('header_notice_web.php');?>
<script type="text/javascript" src="/js/jweixin-1.0.0.js"></script>
<script type="text/javascript" src="/js/wxshare.js"></script>
<script type="text/javascript">
var imgUrl = "<?php echo $site;?>images/wxLOGO.png";
var link = "<?php echo $site;?>";
var title ="拼得好";
var desc = "1毛夺好礼，拼享新玩法";
wxshare(false, '<?php echo $wxShareParam['appId'];?>', <?php echo $wxShareParam['timestamp'];?>, '<?php echo $wxShareParam['nonceStr'];?>', '<?php echo $wxShareParam['signature'];?>', imgUrl, link, title, desc);
</script>
<style>
    .index-download,.content{-webkit-transition:all 0.2s;transition:all 0.2s;}
</style>

<body>
    <div class="page-group" id="page-index">
        <div id="page-nav-bar" class="page page-current">
            <!-- <header class="bar bar-nav">
                <h1 class="title"><img class="title-img" src="images/logo.png" alt="<?php echo $site_name;?>" /></h1>
            </header> -->

            <section class="index-download">
                <span class="close"></span>
                <a class="link" href="http://a.app.qq.com/o/simple.jsp?pkgname=com.qunyu.taoduoduo"></a>
            </section>

            <section class="swiper-container index-class">
                <div class="swiper-wrapper">
                    <a class="swiper-slide" href="index.php?id=0" data-id="0">首页</a>
                    <?php foreach($classification as $class){?>
                        <a href="index.php?id=<?php echo $class['oneId'];?>" class="swiper-slide" data-id="<?php echo $class['oneId'];?>">
                        <?php if($class['oneFlag'] == 0){?>
                            <?php echo $class['oneName'];?>
                        <?php }else{?>
                            <img src="images/nianhuo.png" alt="年货" />
                        <?php } ?>
                        </a>
                    <?php }?>
                </div>
            </section>
            <div class="index-class-placeholder"></div>

            <?php include_once('footer_nav_web.php');?>

            <div class="content native-scroll" style="top:2.0rem;">

                <div id="index_page" class="swiper-container index-page" data-href="api_action.php?act=index&neibu_qy=1">
                    <section class="index-pro infinite-scroll infinite-scroll-bottom" data-distance="30">
                        <!-- 加载提示符 -->
                        <div class="infinite-scroll-preloader">
                            <div class="preloader"></div>
                        </div>
                    </section>
                </div>
            </div>

            <script id='tpl_indexBox' type="text/template">
                <section class="swiper-container index-banner" data-space-between="0">
                    <div class="swiper-wrapper"></div>
                    <div class="swiper-pagination"></div>
                </section>
                <section class="index-menu">
                    <a href="freedraw.php"><span class="index-menuIcon index-menu-i1"></span><span class="txt">免费试用</span></a>
                    <a href="product_guess_price.php"><span class="index-menuIcon index-menu-i2"></span><span class="txt">猜价格</span></a>
                    <a href="special_77.php"><span class="index-menuIcon index-menu-i3"></span><span class="txt">9.9特卖</span></a>
                    <a href="seckill.php"><span class="index-menuIcon index-menu-i4"></span><span class="txt">掌上秒杀</span></a>
                    <a href="lottery_new.php"><span class="index-menuIcon index-menu-i5"></span><span class="txt">抽奖团</span></a>
                </section>
                <section class="index-index infinite-scroll infinite-scroll-bottom" data-distance="30">
                    <!-- <h2 class="index-pro-title"></h2> -->
                    <ul class="list-container">
						<?php foreach($seckillPro as $v){ ?>
							<li><a href="groupon.php?id=<?php echo $v['activityId'];?>">
								<div class="img"><img src="<?php echo $v['productImage'];?>" /></div>
								<div class="info">
									<p class="name"><?php echo $v['productName'];?></p>
									<span class="sales">销量：<?php echo $v['proSellrNum'];?></span>
								</div>
								<div class="group">
									<span class="num"><?php echo $v['groupNum'];?>人团</span>
									￥<span class="now-price"><?php echo $v['productPrice'];?></span>
									<span class="old-price">￥<?php echo $v['alonePrice'];?></span>
								</div>
							</a></li>
						<?php } ?>
					</ul>
                    <div class="infinite-scroll-preloader">
                        <div class="preloader"></div>
                    </div>
                </section>
            </script>

           <script id='tpl_proBox' type="text/template">
                <section class="index-subClass" data-more="search_class.php?act=twoClass&id=<?php echo $cateId;?>&level=1">
                    <ul>
                      <?php foreach ($twoClass as $two){?>
                        <li><a href="search_class.php?act=threeClass&id=<?php echo $two['twoId'];?>&level=2"><div class="img"><img src="<?php echo $two['twoIcon'];?>" /></div><div class="txt"><?php echo $two['twoName'];?></div></a></li>
                      <?php }?>
                    </ul>
                </section>
                <section class="index-pro infinite-scroll infinite-scroll-bottom" data-distance="30">
                <ul class="list-container"></ul>
                <div class="infinite-scroll-preloader">
                    <div class="preloader"></div>
                </div>
                </section>
            </script>

            <script id='tpl_indexBanner' type="text/template">
                <%for(var i=0;i<data["banner"].length; i++){%>
                    <%if(data["banner"][i]["type"] == 2){%>
						<a class="swiper-slide" href="groupon.php?id=<%=data["banner"][i].typeId%>">
                    <%}else if(data["banner"][i]["type"] == 3 && data["banner"][i].typeId !=0 ){%>
						<a class="swiper-slide" href="product_guess_price.php?act=detail&gid=<%=data["banner"][i].typeId%>">
					<%}else if(data["banner"][i]["type"] == 3 && data["banner"][i].typeId == 0){%>
                        <a class="swiper-slide" href="product_guess_price.php">
                    <%}else if(data["banner"][i]["type"] == 4){%>
						<%if(data["banner"][i].typeId == 0){%>
						    <a class="swiper-slide">
                       <%}else{%>
							<a class="swiper-slide" href="special.php?id=<%=data["banner"][i].typeId%>">
						<%}%>
					<%}else if(data["banner"][i]["type"] == 5){%>
						<a class="swiper-slide" href="specials.php?id=<%=data['banner'][i].typeId%>">
                    <%}else if(data["banner"][i]["type"] == 6){%>
						<a class="swiper-slide" href="special_77.php">
                    <%}else if(data["banner"][i]["type"] == 7){%>
						<a class="swiper-slide" href="link.php?url=<%=data["banner"][i].typeId%>&title=<%=data["banner"][i].title%>">
                    <%}else{%>
						<a class="swiper-slide">
                    <%}%>
                        <img src="<%=data["banner"][i].banner%>">
                    </a>
                <%}%>
            </script>

            <script id='tpl_indexPro' type="text/template">
                <%if(data["proData"]["listData"].length>0){%>
                    <%for(var i=0;i<data["proData"]["listData"].length; i++){%>
                        <li><a href="groupon.php?id=<%=data["proData"]["listData"][i]["activityId"]%>">
                            <div class="img"><img src="<%=data["proData"]["listData"][i]["productImage"]%>" /></div>
                            <div class="info">
                                <p class="name"><%=data["proData"]["listData"][i]["productName"]%></p>
                                <span class="sales">销量：<%=data["proData"]["listData"][i]["proSellrNum"]%></span>
                            </div>
                            <div class="group">
                                <span class="num"><%=data["proData"]["listData"][i]["groupNum"]%>人团</span>
                                ￥<span class="now-price"><%=data["proData"]["listData"][i]["productPrice"]%></span>
                                <span class="old-price">￥<%=data["proData"]["listData"][i]["alonePrice"]%></span>
                            </div>
                        </a></li>
                    <%}%>
                <%}else if(data["pageNow"] == 1){%>
                    <div class="tips-null">没有更多商品</div>
                <%}%>
            </script>

            <script id='tpl_indexClass' type="text/template">
                <%if(data["proData"]["listData"].length>0){%>
                    <%for(var i=0;i<data["proData"]["listData"].length; i++){%>
                        <li><a href="groupon.php?id=<%=data["proData"]["listData"][i].activityId%>">
                            <div class="img"><img src="<%=data["proData"]["listData"][i]["productImage"]%>" /></div>
                            <div class="name">
                                <span class="num"><%=data["proData"]["listData"][i]["groupNum"]%>人团</span><%=data["proData"]["listData"][i]["productName"]%>
                            </div>
                            <div class="info">
                                ￥<span class="price"><%=data["proData"]["listData"][i]["productPrice"]%></span>
                                <span class="sales">已团<%=data["proData"]["listData"][i]["proSellrNum"]%>件</span>
                            </div>
                        </a></li>
                    <%}%>
                <%}else if(data["pageNow"] == 1){%>
                    <div class="tips-null">没有更多商品</div>
                <%}%>
            </script>
        </div>
        <?php if(!empty($freeCpn)){?>
            <div class="popup popup-coupon">
                <div>
                    <a href="javascript:;" class="close-popup"></a>
                    <h3 class="title1">您有1张团免券未使用</h3>
                    <div class="freeCoupon">
                        <div class="info">
                            <div class="name">团长免单券 <span>(团长免费开团)</span></div>
                            <div class="tips">点击选择团免商品</div>
                            <div class="time">有效期: <?php echo $cpnStart;?> - <?php echo $cpnEnd;?></div>
                        </div>
                        <div class="price"><div>￥<span>0</span></div></div>
                    </div>
                    <a href="groupon_free.php" class="go">立即前往</a>
                </div>
            </div>
        <?php }?>
        <div class="popup popup-red">
            <div>
                <a href="javascript:;" class="close-popup"></a>
                <img src="images/redpacket2.png" />
                <a class="go"></a>
            </div>
        </div>
        <section id="goTop" class="goTop"></section>
        <!-- <section id="redPacked" class="redPacked"></section> -->
    </div>
</body>

</html>

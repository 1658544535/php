<?php include_once('header_notice_web.php');?>
<script type="text/javascript" src="/js/jweixin-1.0.0.js"></script>
<script type="text/javascript" src="/js/wxshare.js"></script>
<script type="text/javascript">
var imgUrl = "<?php echo $fx['image'];?>";
var link  = "<?php echo $fx['url'];?>";
var title ="<?php echo $fx['title'];;?>";
var desc  ="<?php echo $fx['content'];;?>";

var wxappId = '<?php echo $wxShareParam['appId'];?>',
    wxtimestamp = <?php echo $wxShareParam['timestamp'];?>,
    wxnonceStr = '<?php echo $wxShareParam['nonceStr'];?>',
    wxsignature = '<?php echo $wxShareParam['signature'];?>';
wxshare(false, wxappId, wxtimestamp, wxnonceStr, wxsignature, imgUrl, link, title ,desc);
</script>

<body>
    <div class="page-group" id="page-special-class">
        <div id="page-nav-bar" class="page page-current">
            <header class="bar bar-nav">
                <a class="button button-link button-nav pull-left back" href="javascript:history.back(-1);">
                    <span class="icon icon-back"></span>
                </a>
                <h1 class="title"></h1>
            </header>

            <?php include_once('footer_nav_web.php');?>

            <section class="swiper-container special-class">
                <div class="swiper-wrapper">
					<?php $i=1;?>
					<?php foreach($cates as $v){ ?>
						<a class="swiper-slide<?php echo ($i==1) ? ' active' : '';?>" data-id="<?php echo $v['id'];?>"><span><?php echo $v['name'];?></span></a>
						<?php $i++;?>
					<?php } ?>
                </div>
            </section>

            <div class="content native-scroll" style="top:4.2rem;">
                <div class="swiper-container special-page" data-href="api_action.php?act=specials">
                    <div class="swiper-wrapper">
                        <div class="swiper-slide">
                            <section class="special-index infinite-scroll infinite-scroll-bottom" data-distance="30">
                                <!-- 加载提示符 -->
                                <div class="infinite-scroll-preloader">
                                    <div class="preloader"></div>
                                </div>
                            </section>
                        </div>
                    </div>
                </div>
            </div>

            <script id='tpl_indexClass' type="text/template">
                <%if(data["data"]["list"].length>0){%>
                    <%for(var i=0;i<data["data"]["list"].length; i++){%>
                        <div class="special-item">
                            <a href="special.php?id=<%=data["data"]["list"][i].specialId%>" class="special-item-header swipe-handler">
                                <div class="img">
                                    <img src="<%=data["data"]["list"][i].specialImage%>" />
                                </div>
                                <!--<div class="time">活动剩余时间<p class="downTime" data-timer="400"></p></div>-->
                            </a>
                            <div class="pro">
                                <ul>
									<%for(var j=0,jlen=data["data"]["list"][i]["productList"].length; j<jlen; j++){%>
										<li>
											<a href="groupon.php?id=<%=data["data"]["list"][i]["productList"][j].activityId%>">
												<div class="proImg"><img src="<%=data["data"]["list"][i]["productList"][j].productImage%>" /></div>
												<div class="info">
													<div class="title1"><%=data["data"]["list"][i]["productList"][j].productName%></div>
													<div class="price"><span class="now">￥<%=data["data"]["list"][i]["productList"][j].price%></span><span class="old">￥<%=data["data"]["list"][i]["productList"][j].alonePrice%></span></div>
												</div>
											</a>
										</li>
									<%}%>
									<%if(jlen>=6){%>
									<li>
                                        <a href="special.php?id=<%=data["data"]["list"][i].specialId%>" class="special-more"></a>
                                    </li>
									<%}%>
                                </ul>
                            </div>
                        </div>
                    <%}%>
                <%}else if(data["pageNow"] == 1){%>
                    <div class="tips-null">没有更多专场</div>
                <%}%>
                
            </script>
        </div>
        <section id="goTop" class="goTop"></section>
    </div>
</body>

</html>

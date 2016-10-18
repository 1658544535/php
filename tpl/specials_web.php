<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title><?php echo $site_name;?></title>
    <meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, minimal-ui, user-scalable=0" name="viewport">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <link rel="stylesheet" href="css/sm.min.css">
    <link rel="stylesheet" href="css/all.min.css">
    <link rel="stylesheet" href="js/swiper/swiper.min.css">
    <script type='text/javascript' src='js/zepto.js' charset='utf-8'></script>
    <script type='text/javascript' src='js/baiduTemplate.js' charset='utf-8'></script>
    <script type='text/javascript' src='js/sui/sm.min.js' charset='utf-8'></script>
    <script type='text/javascript' src='js/swiper/swiper.min.js' charset='utf-8'></script>
    <script type='text/javascript' src='js/app.min.js' charset='utf-8'></script>
</head>

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
                <%if(data["data"].length>0){%>
                    <%for(var i=0;i<data["data"].length; i++){%>
                        <div class="special-item">
                            <a href="special.php?id=<%=data["data"][i].specialId%>" class="special-item-header swipe-handler">
                                <div class="img">
                                    <img src="<%=data["data"][i].specialImage%>" />
                                </div>
                                <!--<div class="time">活动剩余时间<p class="downTime" data-timer="400"></p></div>-->
                            </a>
                            <div class="pro">
                                <ul>
									<%for(var j=0,jlen=data["data"][i]["productList"].length; j<jlen; j++){%>
										<li>
											<a href="groupon.php?id=<%=data["data"][i]["productList"][j].activityId%>">
												<div class="proImg"><img src="<%=data["data"][i]["productList"][j].productImage%>" /></div>
												<div class="info">
													<div class="title1"><%=data["data"][i]["productList"][j].productName%></div>
													<div class="price"><span class="now">￥<%=data["data"][i]["productList"][j].price%></span><span class="old">￥<%=data["data"][i]["productList"][j].alonePrice%></span></div>
												</div>
											</a>
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
    </div>
</body>

</html>

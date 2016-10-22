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
    <?php include_once('wxshare_web.php');?>
</head>

<body>
    <div class="page-group" id="page-index">
        <div id="page-nav-bar" class="page page-current">
            <!-- <header class="bar bar-nav">
                <h1 class="title"><img class="title-img" src="images/logo.png" alt="<?php echo $site_name;?>" /></h1>
            </header> -->

            <?php include_once('footer_nav_web.php');?>

            <section class="swiper-container index-class">
                <div class="swiper-wrapper">
                    <a class="swiper-slide active" data-id="0">首页</a>
                    <?php foreach($cates as $_cate){?>
	                    <a class="swiper-slide" data-id="<?php echo $_cate['id'];?>"><?php echo $_cate['name'];?></a>
                    <?php }?>           
                </div>
            </section>

            <div class="content native-scroll" style="top:2.0rem;">

                <div class="swiper-container index-page" data-href="api_action.php?act=index">
                    <div class="swiper-wrapper">
                        <div class="swiper-slide">
                            <section class="index-pro infinite-scroll infinite-scroll-bottom" data-distance="30">
                                <!-- 加载提示符 -->
                                <div class="infinite-scroll-preloader">
                                    <div class="preloader"></div>
                                </div>
                            </section>
                        </div>
                    </div>
                </div>
            </div>

            <script id='tpl_indexBanner' type="text/template">
                <%for(var i=0;i<data["banner"].length; i++){%>
                    <%if(data["banner"][i]["type"] == 2){%>
						<a class="swiper-slide" href="groupon.php?id=<%=data["banner"][i].typeId%>">
                    <%}else if(data["banner"][i]["type"] == 3){%>
						<a class="swiper-slide" href="product_guess_price.php?act=detail&gid=<%=data["banner"][i].typeId%>">
					<%}else if(data["banner"][i]["type"] == 4){%>
						<%if(data["banner"][i].typeId == 0){%>
							<a class="swiper-slide" href="specials.php">
						<%}else{%>
							<a class="swiper-slide" href="special.php?id=<%=data["banner"][i].typeId%>">
						<%}%>
					<%}else if(data["banner"][i]["type"] == 5){%>
						<a class="swiper-slide" href="specials.php">
                    <%}else if(data["banner"][i]["type"] == 6){%>
						<a class="swiper-slide" href="special_77.php">					
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
        <section id="goTop" class="goTop"></section>
    </div>
</body>

</html>

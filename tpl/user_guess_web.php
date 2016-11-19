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
    <link rel="stylesheet" href="css/all.min.css?v=<?php echo SOURCE_VERSOIN;?>">
    <link rel="stylesheet" href="js/swiper/swiper.min.css">
    <script type='text/javascript' src='js/jquery-2.1.4.min.js' charset='utf-8'></script>
    <script>jQuery.noConflict()</script>
    <script type='text/javascript' src='js/zepto.js' charset='utf-8'></script>
    <script type='text/javascript' src='js/baiduTemplate.js' charset='utf-8'></script>
    <script type='text/javascript' src='js/sui/sm.min.js' charset='utf-8'></script>
    <script type='text/javascript' src='js/swiper/swiper.min.js' charset='utf-8'></script>
    <script type='text/javascript' src='js/app.min.js?v=<?php echo SOURCE_VERSOIN;?>' charset='utf-8'></script>
<?php include_once('wxshare_web.php');?>
</head>

<body>
    <div class="page-group" id="page-guess">
        <div id="page-nav-bar" class="page page-current">
            <header class="bar bar-nav">
                <a class="button button-link button-nav pull-left back" href="user.php">
                    <span class="icon icon-back"></span>
                </a>
                <h1 class="title">我的猜价</h1>
            </header>
      
            <div class="content native-scroll">

                <section class="user-tab" data-href="ajaxtpl/ajax_user_guess.php">
                    <ul>
                        <li data-type="0"><a href="user_info.php?act=guess&type=0">全部</a></li>
                        <li data-type="1"><a href="user_info.php?act=guess&type=1">进行中</a></li>
                        <li data-type="2"><a href="user_info.php?act=guess&type=2">已结束</a></li>
                        <li data-type="3"><a href="user_info.php?act=guess&type=3">待开奖</a></li>
                    </ul>
                </section>

                <section class="user-guess clickbox infinite-scroll infinite-scroll-bottom" data-distance="30">
                    <ul class="list-container"></ul>
                    <!-- 加载提示符 -->
                    <div class="infinite-scroll-preloader">
                        <div class="preloader"></div>
                    </div>
                </section>

            </div>

            <script id='tpl_pull_tab' type="text/template">
            <%if(data["data"].length>0){%>
                <%for(var i=0;i<data["data"].length; i++){%>
                    <li>
                        <div class="u-g-1">
                            <span class="type">猜价商品</span>
                                  <%if(data["data"][i].activityStatus ==1){%>
                                   <span class="state">进行中</span>
                                  <%}else if(data["data"][i].activityStatus ==2 && data["data"][i].prize ==1 &&　data["data"][i].isRecCoupon ==1){%>      
                                   <span class="state">一等奖，已完成</span>
                                 <%}else if(data["data"][i].activityStatus ==2 && data["data"][i].prize ==1 &&　data["data"][i].isRecCoupon ==0){%>      
                                   <span class="state">一等奖，待完善信息</span> 
                                  <%}else if(data["data"][i].activityStatus ==2 && data["data"][i].prize ==2 &&　data["data"][i].isRecCoupon ==1){%>
                                   <span class="state">二等奖，已送券</span>
　　　　　　　　　　　　　　　　　　<%}else if(data["data"][i].activityStatus ==2 && data["data"][i].prize ==2 &&　data["data"][i].isRecCoupon ==0){%>
                                   <span class="state">二等奖，奖品发放中...</span>
                                  <%}else if(data["data"][i].activityStatus ==2 && data["data"][i].prize ==3 &&　data["data"][i].isRecCoupon ==1){%>
                                   <span class="state">三等奖，已送券</span>
                                  <%}else if(data["data"][i].activityStatus ==2 && data["data"][i].prize ==3 &&　data["data"][i].isRecCoupon ==0){%>
                                   <span class="state">三等奖，奖品发放中...</span>
                                  <%}else if(data["data"][i].activityStatus ==3){%>
                                   <span class="state">待开奖</span>
                                  <%}%>
                          </div>
                        <a href="product_guess_price.php?act=detail&gid=<%=data["data"][i]["activityId"]%>&pid=<%=data["data"][i]["productId"]%>" class="u-g-2">
                            <div class="img"><img src="<%=data["data"][i]["productImage"]%>" /></div>
                            <div class="info">
                                <div class="name"><%=data["data"][i]["productName"]%></div>
                                <div class="price">
                                    <%if(data["data"][i].activityStatus ==2){%>
                                     <span>最终价格：<font class="themeColor">￥<%=data["data"][i]["realPrice"]%></font></span>                                    
                                    <%}else{%>
                                     <span>价格区间：<font class="themeColor">￥<%=data["data"][i]["minPrice"]%>-<%=data["data"][i]["maxPrice"]%></font></span>
                                    <%}%>
                                    <span class="price2">我的猜价：<font class="themeColor">￥<%=data["data"][i]["userPrice"]%></font></span>
                                </div>
                            </div>
                        </a>
                        <div class="u-g-3">
                            <a href="product_guess_price.php?act=detail&gid=<%=data["data"][i]["activityId"]%>&pid=<%=data["data"][i]["productId"]%>">查看详情</a>
                        </div>
                    </li>
                <%}%>
            <%}else if(data["pageNow"] == 1){%>
                <div class="tips-null">暂无猜价</div>
            <%}%>
            </script>

        </div>
        <section id="goTop" class="goTop"></section>
    </div>
</body>

</html>

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
    <div class="page-group" id="page-lottery">
        <div id="page-nav-bar" class="page page-current">
            <header class="bar bar-nav">
                <a class="button button-link button-nav pull-left back">
                    <span class="icon icon-back"></span>
                </a>
                <a class="button button-link button-nav pull-right share">
                    <span class="icon icon-share"></span>
                </a>
                <h1 class="title">0.1抽奖</h1>
            </header>

            <ul class="bar bar-tab user-tab user-tabBar" data-href="ajaxtpl/ajax_lottery.php">
                <li class="tab-item tab-item2 active" data-type="1">
                    <span class="icon i-lotterying"></span>
                    <span class="tab-label">正在进行</span>
                </li>
                <li class="tab-item tab-item2" data-type="2">
                    <span class="icon i-lotteryed"></span>
                    <span class="tab-label">查看往期</span>
                </li>
            </ul>

            <div class="content native-scroll">
                <?php if($Type ==1){?>
                <section class="lottery-rule"><img src="<?php echo $Banner['banner'];?>" /></section>
                <?php }?>
                <section class="index-seckill clickbox infinite-scroll infinite-scroll-bottom" data-distance="30" data-href="">
                    <ul class="list-container"></ul>
                    <!-- 加载提示符 -->
                    <div class="infinite-scroll-preloader">
                        <div class="preloader"></div>
                    </div>
                </section>
            </div>
<?php if($Type ==1){?>        
            <script id='tpl_pull_tab' type="text/template">
                <%if(data["data"].length>0){%>
                    <%for(var i=0;i<data["data"].length; i++){%>
                        <li><a href="groupon.php?id=<%=data["data"][i]["activityId"]%>">
                            <div class="img"><img src="<%=data["data"][i]["productImage"]%>" /></div>
                            <div class="info">
                                <div class="name"><span class="num"><%=data["data"][i]["groupNum"]%>人团</span><%=data["data"][i]["productName"]%></div>
                                <div class="price">
                                    <span class="price1">￥<%=data["data"][i]["productPrice"]%></span>
                                </div>
                                <div class="btn">
                                    <span class="red">立即开团</span>
                                </div>
                            </div>
                        </a></li>
                    <%}%>
                <%}else if(data["pageNow"] == 1){%>
                    <div class="tips-null">暂无抽奖</div>
                <%}%>
            </script>
<?php }else{?>
			<script id='tpl_pull_tab' type="text/template">
                <%if(data["data"].length>0){%>
                    <%for(var i=0;i<data["data"].length; i++){%>
                        <li><a href="lottery_new.php?act=comment_list&aid=<%=data["data"][i]["activityId"]%>&pid=<%=data["data"][i]["productId"]%>">
                            <div class="img"><img src="<%=data["data"][i]["productImage"]%>" /></div>
                            <div class="info">
                                <div class="name"><span class="num"><%=data["data"][i]["groupNum"]%>人团</span><%=data["data"][i]["productName"]%></div>
                                <div class="price">
                                    <span class="price1">￥<%=data["data"][i]["productPrice"]%></span>
                                </div>
                                <div class="btn">
                                    <span class="red">查看评论</span>
                                </div>
                            </div>
                        </a></li>
                    <%}%>
                <%}else if(data["pageNow"] == 1){%>
                    <div class="tips-null">暂无抽奖</div>
                <%}%>
            </script>
     <?php }?>   
        </div>

        <div class="popup popup-share">
            <a href="#" class="close-popup"></a>
        </div>
    </div>
</body>

</html>
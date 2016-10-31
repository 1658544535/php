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
    <link rel="stylesheet" href="css/sm-extend.min.css">
    <link rel="stylesheet" href="css/all.min.css">
    <link rel="stylesheet" href="js/swiper/swiper.min.css">
    <script type='text/javascript' src='js/zepto.js' charset='utf-8'></script>
    <script type='text/javascript' src='js/baiduTemplate.js' charset='utf-8'></script>
    <script type='text/javascript' src='js/sui/sm.min.js' charset='utf-8'></script>
    <script type='text/javascript' src='js/sui/sm-extend.min.js' charset='utf-8'></script>
    <script type='text/javascript' src='js/swiper/swiper.min.js' charset='utf-8'></script>
    <script type='text/javascript' src='js/app.min.js' charset='utf-8'></script>
</head>

<body>
    <div class="page-group" id="page-evaluate">
        <div id="page-nav-bar" class="page page-current">
            <header class="bar bar-nav">
                <a class="button button-link button-nav pull-left back" href="lottery_new.php?type=2">
                    <span class="icon icon-back"></span>
                </a>
                <h1 class="title">评价列表</h1>
            </header>

            <div class="content native-scroll">
                <section class="evaluate-pro">
                    <div class="img"><img src="<?php echo $LotteryCommentList['productImage'];?>" /></div>
                    <div class="name"><?php echo $LotteryCommentList['productName'];?></div>
                </section>

                <section class="evaluate-list pullbox infinite-scroll infinite-scroll-bottom" data-distance="30" data-href="ajaxtpl/ajax_lottery_comment.php?aid=<?php echo $aId;?>">
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
                            <div class="header">
                                <div class="img"><img src="<%=data["data"][i]["userImage"]%>" /></div>
                                <div class="info">
                                    <div class="name"><%=data["data"][i]["userName"]%></div>
                                    <div class="time"><%=data["data"][i]["commentTime"]%></div>
                                </div>
                            </div>
                            <div class="txt"><%=data["data"][i]["commentText"]%></div>
                           <%if(data["data"][i]["commentImage"]["image"] !=''){%>
                            <div class="imgs">
                                <%for(var j=0;j<data["data"][i]["commentImage"]["image"].length; j++){%>
                                <div><img src="<%=data["data"][i]["commentImage"]["image"][j]%>" /></div>
                                <%}%>
                            </div>
                           <%}%> 
                       </li>
                    <%}%>
                <%}else if(data["pageNow"] == 1){%>
                    <div class="tips-null">暂无评价</div>
                <%}%>
            </script>

        </div>

    </div>
</body>

</html>

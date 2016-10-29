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
    <div class="page-group" id="page-lotteryresult">
        <div id="page-nav-bar" class="page page-current">
            <header class="bar bar-nav">
                <a class="button button-link button-nav pull-left back" href="">
                    <span class="icon icon-back"></span>
                </a>
                <h1 class="title">中奖结果</h1>
            </header>

            <div class="content native-scroll">

                <section class="lotteryresult-pro">
                    <div class="img"><img src="<?php echo $winInfo['productImage'];?>" /></div>
                    <div class="info">
                        <div class="name"><?php echo $winInfo['productName'];?></div>
                        <div class="price">￥<span>0.1</span></div>
                        <div class="btn">已开奖</div>
                    </div>
                </section>

                <section class="deta-group pullbox infinite-scroll infinite-scroll-bottom" data-distance="30" data-href="ajaxtpl/ajax_lottery_win.php">
                    <h3 class="title1">获奖用户列表</h3>
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
                        <li class="head">
                          <%if(data["data"][i]["isHead"] ==1){%>  
                          <div class="img"><img src="<%=data["data"][i]["userlogo"]%>" /><span class="head">团长</span></div>
                           <%}%> 
                            <div class="info">
                                <div class="name"><%=data["data"][i]["name"]%></div>
                                <div class="no"><%=data["data"][i]["orderNo"]%></div>
                                <div class="tel"><%=data["data"][i]["loginname"]%></div>
                            </div>
                        </li>
                        <li>
                          <%if(data["data"][i]["isHead"] ==0){%> 
                           <div class="img"><img src="<img src="<%=data["data"][i]["userlogo"]%>" /><span class="head">团员</span></div>
                          <%}%>
                            <div class="info">
                                <div class="name"><%=data["data"][i]["name"]%></div>
                                <div class="no"><%=data["data"][i]["orderNo"]%></div>
                                <div class="tel"><%=data["data"][i]["loginname"]%></div>
                            </div>
                        </li>
                    <%}%>
                <%}else if(data["pageNow"] == 1){%>
                    <div class="tips-null">暂无抽奖</div>
                <%}%>
            </script>

        </div>
    </div>
</body>

</html>

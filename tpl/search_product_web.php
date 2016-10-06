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
    <div class="page-group" id="page-search">
        <div id="page-nav-bar" class="page page-current">
            <header class="bar bar-nav">
                <a class="button button-link button-nav pull-left back" href="javascript:history.back(-1);">
                    <span class="icon icon-back"></span>
                </a>
                <a class="button button-link button-nav pull-right search" onclick="$('#searchForm').submit()">搜索</a>
                <div class="bar-search">
                    <form id="searchForm" action="search_product.php">
                        <div class="txt"><input type="text" name="name" placeholder="搜索商品" /></div>
                        <span class="clearTxt"></span>
                    </form>
                </div>
            </header>
            <?php include_once('footer_nav_web.php');?>

            

            <div class="content native-scroll">
             <?php if($search['result']['count'] !=''){?>
                <div class="searchTips">共找到<span id="searchNum"><?php echo $search['result']['count']?></span>条相关结果</div>
             <?php }?>
                <section class="index-pro pullbox infinite-scroll infinite-scroll-bottom" data-distance="30" data-href="ajaxtpl/ajax_search.php?name=<?php echo $name ;?>">
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
                    <li><a href="groupon.php?id=<%=data["data"][i]["activityId"]%>">
                        <div class="img"><img src="<%=data["data"][i]["productImage"]%>" /></div>
                        <div class="name">
                            <span class="num"><%=data["data"][i]["groupNum"]%>人团</span><%=data["data"][i]["productName"]%>
                        </div>
                        <div class="info">
                            ￥<span class="price"><%=data["data"][i]["productPrice"]%></span>
                            <span class="sales">已团<%=data["data"][i]["attendNum"]%>件</span>
                        </div>
                    </a></li>
                <%}%>
            <%}else{%>
                <div class="tips-null">暂无商品</div>
            <%}%>
            </script>
            
        </div>
    </div>
</body>

</html>
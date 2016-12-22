<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>拼得好</title>
    <meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, minimal-ui, user-scalable=0" name="viewport">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <link rel="stylesheet" href="css/sm.min.css">
    <link rel="stylesheet" href="css/all.min.css">
    <link rel="stylesheet" href="js/swiper/swiper.min.css">
    <script type='text/javascript' src='js/jquery-2.1.4.min.js' charset='utf-8'></script>
    <script>jQuery.noConflict()</script>
    <script type='text/javascript' src='js/zepto.js' charset='utf-8'></script>
    <script type='text/javascript' src='js/baiduTemplate.js' charset='utf-8'></script>
    <script type='text/javascript' src='js/sui/sm.min.js' charset='utf-8'></script>
    <script type='text/javascript' src='js/swiper/swiper.min.js' charset='utf-8'></script>
    <script type='text/javascript' src='js/app.min.js' charset='utf-8'></script>
</head>

<body>
<div class="page-group" id="page-messageList">
    <div id="page-nav-bar" class="page page-current">
        <header class="bar bar-nav">
            <a class="button button-link button-nav pull-left back" href="javascript:history.back(-1);">
                <span class="icon icon-back"></span>
            </a>
            <h1 class="title">消息</h1>
        </header>

        <?php include_once ('./tpl/footer_nav_web.php');?>

        <div class="content native-scroll pull-to-refresh-content" data-ptr-distance="55">
            <!-- 默认的下拉刷新层 -->
            <div class="pull-to-refresh-layer">
                <div class="preloader"></div>
                <div class="pull-to-refresh-arrow"></div>
            </div>

            <section class="message-list" data-href="/ajaxtpl/ajax_message_scroll.php?type=<?php echo $messageType;?>">
                <ul></ul>
                <div class="infinite-scroll-preloader">
                    <div class="preloader"></div>
                </div>
            </section>
        </div>

        <script id='tpl_pull' type="text/template">
            <%if(data["data"].length>0){%>
                <%for(var i=0;i<data["data"].length; i++){%>
                    <li class="message-list-item">
                        <div class="time"><%=data["data"][i]["time"]%></div>
                        <div class="main">
                            <a href="<%=data["data"][i]["url"]%>">
                                <h3 class="title1"><%=data["data"][i]["title"]%></h3>
                                <div class="good">
                                    <div class="g-img"><img src="<%=data['data'][i]['productImage']%>" /></div>
                                    <div class="g-title"><%=data["data"][i]["productName"]%></div>
                                </div>
                                <div class="order">
                                    <p><%=data["data"][i]["content"]%></p>
                                </div>
                                <div class="go"><%=data["data"][i]["linkName"]%></div>
                            </a>
                        </div>
                    </li>
                <%}%>
            <%}else if(data["pageNow"] == 1){%>
                <div class="tips-null">没有更多消息</div>
            <%}%>
        </script>

        <!-- <li class="message-list-item">
            <div class="time">2016年11月19日 下午7：14</div>
            <div class="main">
                <a href="#">
                    <h3 class="title1">宜家做了个25㎡的破烂样板房，却让无数人流下眼泪，过富氧生活</h3>
                    <div class="time">11月19日</div>
                    <div class="img"><img src="images/img/banner.jpg" /></div>
                    <div class="txt">有爱的样板房才是最温馨的样板房！</div>
                    <div class="go">阅读全文</div>
                </a>
            </div>
        </li> -->

    </div>
</div>
</body>

</html>

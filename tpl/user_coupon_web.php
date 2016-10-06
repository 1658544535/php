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
    <div class="page-group" id="page-coupon">
        <div id="page-nav-bar" class="page page-current">
            <header class="bar bar-nav">
                <a class="button button-link button-nav pull-left back" href="javascript:history.back(-1);">
                    <span class="icon icon-back"></span>
                </a>
                <h1 class="title">优惠券</h1>
            </header>

            <div class="content native-scroll">

                <section class="user-tab user-tab3" data-href="ajaxtpl/ajax_user_coupon_new.php">
                    <ul>
                        <li data-type="1"><a href="javascript:;">未使用（<?php if($coupon['result']['notUsedNum'] !=''){ echo $coupon['result']['notUsedNum'];}else{ echo 0; } ?>）</a></li>
                        <li data-type="2"><a href="javascript:;">已过期（<?php if($coupon['result']['overdueNum'] !=''){echo $coupon['result']['overdueNum'];}else{ echo 0; } ?>）</a></li>
                        <li data-type="3"><a href="javascript:;">已使用（<?php if($coupon['result']['usedNum'] !=''){echo $coupon['result']['usedNum'];}else{ echo 0;} ?>）</a></li>
                    </ul>
                </section>

                <section class="user-coupon clickbox infinite-scroll infinite-scroll-bottom" data-distance="30">
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
                        <div class="freeCoupon">
                            <div class="info">
                                <div class="name"><%=data["data"][0]["couponList"][i]["couponName"]%><span>(团长免费开团)</span></div>
                                <div class="tips">点击选择团免商品</div>
                                <div class="time">有效期: <%=data["data"][0]["couponList"][i]["validStime"]%>-<%=data["data"][0]["couponList"][i]["validEtime"]%></div>
                            </div>
                            <div class="price"><div>￥<span>0</span></div></div>
                            <div class="overdue"><!--已过期--></div>
                        </div>
                    </li>
                <%}%>
            <%}else{%>
                <li class="null"></li>
            <%}%>
            </script>

        </div>
    </div>
</body>

</html>

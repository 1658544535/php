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
    <div class="page-group" id="page-afterSales">
        <div id="page-nav-bar" class="page page-current">
            <header class="bar bar-nav">
                <a class="button button-link button-nav pull-left back" href="user.php">
                    <span class="icon icon-back"></span>
                </a>
                <h1 class="title">售后列表</h1>
            </header>

            <div class="content native-scroll">

                <section class="user-tab user-tab5" data-href="api_action.php?act=aftersale">
                    <ul>
                        <li data-type="0"><a href="aftersale.php?type=0">全部</a></li>
                        <li data-type="1"><a href="aftersale.php?type=1">审核中</a></li>
                        <li data-type="2"><a href="aftersale.php?type=2">审核通过</a></li>
                        <li data-type="3"><a href="aftersale.php?type=3">审核不通过</a></li>
                        <li data-type="4"><a href="aftersale.php?type=4">完成</a></li>
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
                            <span class="type">拼团商品</span>
                            <span class="state">
								<%if(data["data"][i].refundStatus == 0){%>
									待审核
								<%}else if(data["data"][i].refundStatus == 1){%>
									审核中
								<%}else if(data["data"][i].refundStatus == 2){%>
									审核通过，请退货
								<%}else if(data["data"][i].refundStatus == 3){%>
									退货中
								<%}else if(data["data"][i].refundStatus == 4){%>
									退货成功
								<%}else if(data["data"][i].refundStatus == 5){%>
									退货失败
								<%}else if(data["data"][i].refundStatus == 6){%>
									审核不通过
								<%}else if(data["data"][i].refundStatus == 7){%>
									已完成
								<%}%>
							</span>
                        </div>
                        <a href="/groupon.php?act=guess&pid=<%=data["data"][i]["productId"]%>" class="u-g-2">
                            <div class="img"><img src="<%=data["data"][i].productImage%>" /></div>
                            <div class="info">
                                <div class="name"><%=data["data"][i].productName%></div>
                                <div class="price">
                                    <div class="price3">实付：<span>￥<%=data["data"][i].orderPrice%></span>（免运费）</div>
                                </div>
                            </div>
                        </a>
                        <div class="u-g-3">
							<%if(data["data"][i].refundStatus == 3){%>
								<div class="reason">理由：<%=data["data"][i].reason%></div>
							<%}%>
							<a href="aftersale.php?act=detail&oid=<%=data["data"][i].orderId%>" class="gray">售后详情</a>
							<%if(data["data"][i].refundStatus == 3){%>
								 <a href="aftersale.php?act=logistics&oid=<%=data["data"][i].orderId%>">查看物流</a>
							<%}else if(data["data"][i].refundStatus == 2){%>
								 <a href="aftersale.php?act=tracking&oid=<%=data["data"][i].orderId%>">填写运单号</a>
							<%}%>
                        </div>
                    </li>
                <%}%>
            <%}else if(data["pageNow"] == 1){%>
                <div class="tips-null">暂无售后</div>
            <%}%>
            </script>

        </div>
        <section id="goTop" class="goTop"></section>
    </div>
</body>

</html>

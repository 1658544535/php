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
    <div class="page-group" id="page-orderList">
        <div id="page-nav-bar" class="page page-current">
            <header class="bar bar-nav">
                <a class="button button-link button-nav pull-left back" href="user.php">
                    <span class="icon icon-back"></span>
                </a>
                <h1 class="title">我的订单</h1>
            </header>

            <div class="content native-scroll">

                <section class="user-tab user-tab6" data-href="ajaxtpl/ajax_user_orders.php">
                    <ul>
                        <li data-type="7"><a href="user_orders.php?type=7">全部</a></li>
                        <li data-type="1"><a href="user_orders.php?type=1">待付款</a></li>
                        <li data-type="2"><a href="user_orders.php?type=2">拼团中</a></li>
                        <li data-type="21"><a href="user_orders.php?type=21">待发货</a></li>
                        <li data-type="3"><a href="user_orders.php?type=3">待收货</a></li>
                        <li data-type="4"><a href="user_orders.php?type=4">已完成</a></li>
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
                               <%if(data["data"][i].source !=5 && data["data"][i].orderStatus ==1 && data["data"][i].isCancel ==0 ){%>                                  
                                                                           待支付
                               <%}else if(data["data"][i].source !=5 && data["data"][i].orderStatus ==2 && data["data"][i].isSuccess ==1 ){%>
                                                                           已成团，待发货
                               <%}else if(data["data"][i].source !=5 && data["data"][i].orderStatus ==3 ){%>    
                                                                            待收货 
                               <%}else if(data["data"][i].source !=5 && data["data"][i].orderStatus ==4 ){%>
                                                                             已完成                               
                               <%}else if(data["data"][i].source !=5 && data["data"][i].orderStatus ==2   && data["data"][i].isSuccess ==0){%>
                                                                             拼团中，还差<%=data["data"][i].oweNum %>人
                               <%}else if(data["data"][i].source !=5 && data["data"][i].orderStatus ==1   && data["data"][i].isCancel ==1){%>
                                                                             交易已取消       
                               <%}else if(data["data"][i].source !=5 && data["data"][i].isSuccess ==2 && (data["data"][i].isRefund ==0) || (data["data"][i].isRefund ==1) ){%>
                                                                             未成团，退款中  
                               <%}else if(data["data"][i].source !=5 && data["data"][i].isSuccess ==2 && data["data"][i].isRefund ==2){%>
                                                                             未成团，已退款 
                               <%}else if(data["data"][i].source ==5 &&  data["data"][i].isPrize ==0 && data["data"][i].isRefund ==2){%>
                                                                             未中奖，已返款
                               <%}else if(data["data"][i].source ==5 && data["data"][i].orderStatus ==6){%>
                                                                             未中奖，待返款
                               <%}else if(data["data"][i].source ==5 && data["data"][i].isPrize ==1 && data["data"][i].orderStatus ==4){%>
                                                                             已中奖，已完成 
                               <%}else if(data["data"][i].source ==5 && data["data"][i].isPrize ==1 && data["data"][i].orderStatus ==2){%>
                                                                             已中奖，待发货
                               <%}else if(data["data"][i].source ==5 && data["data"][i].isPrize ==1 && data["data"][i].orderStatus ==3){%>
                                                                             已中奖，待收货 
                               <%}else if(data["data"][i].source ==5 && data["data"][i].orderStatus ==1 && data["data"][i].isCancel ==0 ){%>                                  
                                                                             待支付
                               <%}else if(data["data"][i].source ==5 && data["data"][i].orderStatus ==2   && data["data"][i].isSuccess ==0){%>
                                                                             拼团中，还差<%=data["data"][i].oweNum %>人
                               <%}else if(data["data"][i].source ==5 && data["data"][i].orderStatus ==1   && data["data"][i].isCancel ==1){%>
                                                                             交易已取消       
                               <%}else if(data["data"][i].source ==5 && data["data"][i].orderStatus ==3 && data["data"][i].isSuccess ==2 && (data["data"][i].isRefund ==0) || (data["data"][i].isRefund ==1) ){%>
                                                                             未成团，退款中  
                               <%}else if(data["data"][i].source ==5 && data["data"][i].orderStatus ==4 && data["data"][i].isSuccess ==2 && data["data"][i].isRefund ==2){%>
                                                                             未成团，已退款 
                               <%}%>
                             </span>
                        </div>
                        <a href="order_detail.php?oid=<%=data["data"][i]["id"]%>" class="u-g-2">
                            <div class="img"><img src="<%=data["data"][i]["productImage"]%>" /></div>
                            <div class="info">
                                <div class="name"><%=data["data"][i]["productName"]%></div>
                                <div class="price">
                                    <div class="price3">实付：<span>￥<%=data["data"][i]["orderPrice"]%></span>（免运费）</div>
                                </div>
                            </div>
                        </a>
                        <div class="u-g-3">
                           <%if(data["data"][i].orderStatus ==1 && data["data"][i].isCancel ==0){%>  
                            <a class="gray orderCancel" data-id="<%=data["data"][i]["id"]%>">取消</a>
                            <a href="/wxpay/pay.php?oid=<%=data["data"][i]["id"]%>">去支付</a>
                           <%}else if(data["data"][i].orderStatus ==3){%>
                            <a class="gray" href="logistics.php?oid=<%=data["data"][i]["id"]%>">查看物流</a>
                            <%if(data["data"][i].refundStatus ==0 || data["data"][i].refundStatus ==6 || data["data"][i].refundStatus ==5){%>
                            <a class="check" data-id="<%=data["data"][i]["id"]%>" data-status="<%=data["data"][i]["orderStatus"]%>">确认收货</a>
                           <%}%>
                           <%}else if(data["data"][i].orderStatus ==3   && data["data"][i].isSuccess ==1 && data["data"][i].refundStatus ==0){%>
                            <a href="aftersale.php?act=apply&oid=<%=data["data"][i]["id"]%>">申请退款</a>
                           <%}else if(data["data"][i].orderStatus ==2   && data["data"][i].isSuccess ==1 && data["data"][i].refundStatus ==1){%>
                            <a class="txt">售后申请中...</a>
                           <%}else if(data["data"][i].orderStatus ==2   && data["data"][i].isSuccess ==0 ){%> 
                            <a class="gray" href="order_detail.php?oid=<%=data["data"][i]["id"]%>">查看</a>
                            <a href="groupon_join.php?aid=<%=data["data"][i]["attendId"]%>">邀请好友拼团</a>
                           <%}else if(data["data"][i].isSuccess ==2){%> 
                            <a class="gray" href="order_detail.php?oid=<%=data["data"][i]["id"]%>">查看</a>
                            <%if(data["data"][i].source ==5){%>
                             <a href="lottery_new.php?act=winning&attId=<%=data["data"][i]["attendId"]%>">中奖信息</a>
                            <%}%>
                            <%}else if(data["data"][i].source ==5 && data["data"][i].orderStatus ==6){%> 
                             <a href="lottery_new.php?act=winning&attId=<%=data["data"][i]["attendId"]%>">中奖信息</a>
                            <%}else if(data["data"][i].source ==5 && data["data"][i].orderStatus ==7){%> 
                             <a href="lottery_new.php?act=winning&attId=<%=data["data"][i]["attendId"]%>">中奖信息</a>
                            <%}else if(data["data"][i].source ==5 && data["data"][i].orderStatus ==10){%> 
                             <a href="lottery_new.php?act=winning&attId=<%=data["data"][i]["attendId"]%>">中奖信息</a>
                            <%}else if(data["data"][i].source ==5 && data["data"][i].orderStatus ==11){%> 
                              <a href="lottery_new.php?act=winning&attId=<%=data["data"][i]["attendId"]%>">中奖信息</a>
                              <a class="gray" href="logistics.php?oid=<%=data["data"][i]["id"]%>">查看物流</a>                             
                              <a class="check" data-id="<%=data["data"][i]["id"]%>" data-status="<%=data["data"][i]["orderStatus"]%>">确认收货</a>
                           <%}%>                         
                       </div>
                    </li>
                <%}%>
            <%}else if(data["pageNow"] == 1){%>
                <li class="null"></li>
            <%}%>
            </script>
			<script>
				$(document).on("pageInit", "#page-orderList", function(e, pageId, page) {
		           $(document).on("click", ".orderCancel", function(){
						var _this = $(this);
	                	$.confirm("是否取消订单？", function(){
		                    $.post("user_orders.php",{act: "cancel", oid: _this.attr("data-id")},function(req){
		                    	req =  eval("(" + req + ")");;
		                        $.toast(req.data.data.error_msg);
								location.href=document.location;
		                    },"JSON");
	                	});
	                });
	                $(document).on("click", ".check", function(){
		                var _this = $(this);
	                	$.confirm("是否确定收货？", function(){
		                    $.post("user_orders.php",{act: "edit", oid:_this.attr("data-id"), status:_this.attr("data-status")},function(req){
		                    	req =  eval("(" + req + ")");;
		                        $.toast(req.data.data.error_msg);
								location.href=document.location;
		                    },"JSON");
	                	});
	                });
	            })
			</script>
        </div>
        <section id="goTop" class="goTop"></section>
    </div>
</body>

</html>

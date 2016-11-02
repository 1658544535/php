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
    <div class="page-group" id="page-orderCofirm">
        <div id="page-nav-bar" class="page page-current">
            <header class="bar bar-nav">
                <a class="button button-link button-nav pull-left back" href="javascript:history.back(-1);">
                    <span class="icon icon-back"></span>
                </a>
                <?php if($OrderDetail['result']['source'] !=5 && $OrderDetail['result']['orderStatus'] ==1 && $OrderDetail['result']['isCancel'] ==0){?>
                <h1 class="title">确认订单</h1>
                <?php }elseif($OrderDetail['result']['source'] !=5 && $OrderDetail['result']['orderStatus'] ==2 && $OrderDetail['result']['isSuccess'] ==1 ){?>
                <h1 class="title">拼团成功</h1>
                <?php }elseif($OrderDetail['result']['source'] !=5 && $OrderDetail['result']['orderStatus'] ==3){?>
                <h1 class="title">待收货</h1>
                <?php }elseif($OrderDetail['result']['source'] !=5 && $OrderDetail['result']['orderStatus'] ==2 && $OrderDetail['result']['isSuccess'] ==0){?>
                <h1 class="title">拼团中</h1>
                <?php }elseif($OrderDetail['result']['source'] !=5 && $OrderDetail['result']['isCancel'] ==1 && $OrderDetail['result']['orderStatus'] ==1){?>
                <h1 class="title">交易已取消</h1>
                <?php }elseif($OrderDetail['result']['source'] !=5 && $OrderDetail['result']['orderStatus'] ==4){?>
                <h1 class="title">已签收</h1>
                <?php }elseif($OrderDetail['result']['source'] !=5 && $OrderDetail['result']['isSuccess'] ==2){?>
                <h1 class="title">拼团失败</h1>
                <?php }elseif($OrderDetail['result']['source'] ==5 && $OrderDetail['result']['orderStatus'] ==1){?>
                <h1 class="title">确认订单</h1>
                <?php }elseif($OrderDetail['result']['source'] ==5 && $OrderDetail['result']['orderStatus'] ==10){?>
                <h1 class="title">拼团成功</h1>
                <?php }elseif($OrderDetail['result']['source'] ==5 && $OrderDetail['result']['orderStatus'] ==11){?>
                <h1 class="title">待收货</h1>
                <?php }elseif($OrderDetail['result']['source'] ==5 && $OrderDetail['result']['orderStatus'] ==2){?>
                <h1 class="title">拼团中</h1>
                <?php }elseif($OrderDetail['result']['source'] ==5 && $OrderDetail['result']['orderStatus'] ==5){?>
                <h1 class="title">交易已取消</h1>
                <?php }elseif($OrderDetail['result']['source'] ==5 && $OrderDetail['result']['orderStatus'] ==6){?>
                <h1 class="title">未中奖</h1>
                <?php }elseif($OrderDetail['result']['source'] ==5 && $OrderDetail['result']['orderStatus'] ==7){?>
                <h1 class="title">未中奖</h1>
                <?php }elseif($OrderDetail['result']['source'] ==5 && $OrderDetail['result']['orderStatus'] ==9){?>
                <h1 class="title">已签收</h1>
                <?php }elseif($OrderDetail['result']['source'] ==5 ){?>
                <h1 class="title">拼团失败</h1>
                <?php }?>
            </header>
          <div class="content native-scroll" style="bottom:2.75rem;">
                <?php if($OrderDetail['result']['source'] !=5 && $OrderDetail['result']['orderStatus'] ==2 && $OrderDetail['result']['isSuccess'] ==1){?>
                <div class="oc-state"><span>拼团成功，等待卖家发货！</span><i class="o-icon o-icon-1"></i></div>
                <?php }elseif($OrderDetail['result']['source'] !=5 && $OrderDetail['result']['orderStatus'] ==1 && $OrderDetail['result']['isCancel'] ==0){?>
                <div class="oc-state"><span>等待买家付款</span><i class="o-icon o-icon-2"></i></div>
                <?php }elseif($OrderDetail['result']['source'] !=5 && $OrderDetail['result']['orderStatus'] ==3){?>
                <div class="oc-state"><span>卖家已发货</span><i class="o-icon o-icon-3"></i></div>
                <?php }elseif($OrderDetail['result']['source'] !=5 && $OrderDetail['result']['orderStatus'] ==2 && $OrderDetail['result']['isSuccess'] ==0){?>
                <div class="oc-state"><span>拼团还未成功，赶快召唤小伙伴！</span><i class="o-icon o-icon-4"></i></div>
                <?php }elseif($OrderDetail['result']['source'] !=5 && $OrderDetail['result']['isCancel'] ==1 && $OrderDetail['result']['orderStatus'] ==1 ){?>
                <div class="oc-state"><span>交易已取消</span><i class="o-icon o-icon-5"></i></div>
                <?php }elseif($OrderDetail['result']['source'] !=5 && $OrderDetail['result']['orderStatus'] ==4){?>
                <div class="oc-state"><span>交易成功！</span><i class="o-icon o-icon-6"></i></div>
                <?php }elseif($OrderDetail['result']['source'] !=5 && $OrderDetail['result']['isSuccess'] ==2 ){?>
                <div class="oc-state"><span>未成团，退款中</span><i class="o-icon o-icon-8"></i></div>
                <?php }elseif($OrderDetail['result']['source'] !=5 && $OrderDetail['result']['isSuccess'] ==2 && $OrderDetail['result']['refPriStatus'] ==2){?>
                <div class="oc-state"><span>未成团，退款成功</span><i class="o-icon o-icon-7"></i></div>
                <?php }else if($OrderDetail['result']['source'] ==5 && $OrderDetail['result']['orderStatus'] ==10){?>
                <div class="oc-state"><span>拼团成功，等待卖家发货！</span><i class="o-icon o-icon-1"></i></div>
                <?php }else if($OrderDetail['result']['source'] ==5 && $OrderDetail['result']['orderStatus'] ==1){?>
                <div class="oc-state"><span>等待买家付款</span><i class="o-icon o-icon-2"></i></div>
                <?php }else if($OrderDetail['result']['source'] ==5 && $OrderDetail['result']['orderStatus'] ==11){?>
                <div class="oc-state"><span>卖家已发货</span><i class="o-icon o-icon-3"></i></div>
                <?php }else if($OrderDetail['result']['source'] ==5 && $OrderDetail['result']['orderStatus'] ==2){?>
                <div class="oc-state"><span>拼团还未成功，赶快召唤小伙伴！</span><i class="o-icon o-icon-4"></i></div>
                <?php }else if($OrderDetail['result']['source'] ==5 && $OrderDetail['result']['orderStatus'] ==5){?>
                 <div class="oc-state"><span>交易已取消</span><i class="o-icon o-icon-5"></i></div>
                <?php }else if($OrderDetail['result']['source'] ==5 && $OrderDetail['result']['orderStatus'] ==9){?>
                <div class="oc-state"><span>交易成功！</span><i class="o-icon o-icon-6"></i></div>
                <?php }else if($OrderDetail['result']['source'] ==5 && $OrderDetail['result']['orderStatus'] ==3){?>
                <div class="oc-state"><span>未成团，退款中</span><i class="o-icon o-icon-8"></i></div>
                <?php }else if($OrderDetail['result']['source'] ==5 && $OrderDetail['result']['orderStatus'] ==4){?>
                <div class="oc-state"><span>未成团，退款成功</span><i class="o-icon o-icon-7"></i></div>
                <?php }else if($OrderDetail['result']['source'] ==5 && $OrderDetail['result']['orderStatus'] ==6){?>
                <div class="oc-state"><span>未中奖，待返款</span><i class="o-icon o-icon-8"></i></div>
                <?php }else if($OrderDetail['result']['source'] ==5 && $OrderDetail['result']['orderStatus'] ==7){?>
                <div class="oc-state"><span>未中奖，已返款</span><i class="o-icon o-icon-7"></i></div>
                <?php }?>
            
                <section class="oc-adress oc-adress-disable">
                    <a >
                        <div><?php echo $OrderDetail['result']['addressInfo']['consignee'];?></div>
                        <div><?php echo $OrderDetail['result']['addressInfo']['tel'];?></div>
                        <div><?php echo $OrderDetail['result']['addressInfo']['address'];?></div>
                    </a>
                </section>
            <section class="freeList proTips-2 oc-pro">
                    <?php if($OrderDetail['result']['source'] !=5 && $OrderDetail['result']['orderStatus'] ==2  && $OrderDetail['result']['isSuccess'] ==1){?>
                    <h3 class="title1">拼团商品<span class="tips">已成团，待发货</span></h3>
                    <?php }elseif($OrderDetail['result']['source'] !=5 && $OrderDetail['result']['orderStatus'] ==1  && $OrderDetail['result']['isCancel'] ==0){?>               
                    <h3 class="title1">拼团商品<span class="tips">待支付</span></h3>
                    <?php }elseif($OrderDetail['result']['source'] !=5 && $OrderDetail['result']['orderStatus'] ==3 ){?>
                    <h3 class="title1">拼团商品<span class="tips">待收货</span></h3>
                    <?php }elseif($OrderDetail['result']['source'] !=5 && $OrderDetail['result']['orderStatus'] ==2  && $OrderDetail['result']['isSuccess'] ==0){?>
                    <h3 class="title1">拼团商品<span class="tips">拼团中</span></h3>
                    <?php }elseif($OrderDetail['result']['source'] !=5 && $OrderDetail['result']['isCancel'] ==1 ){?>
                    <h3 class="title1">拼团商品<span class="tips">交易已取消</span></h3>
                    <?php }elseif($OrderDetail['result']['source'] !=5 && $OrderDetail['result']['orderStatus'] ==4 ){?>
                    <h3 class="title1">拼团商品<span class="tips">已签收</span></h3>
                    <?php }elseif($OrderDetail['result']['source'] !=5 && $OrderDetail['result']['isSuccess'] ==2 && $OrderDetail['result']['refPriStatus'] ==1){?>
	                <h3 class="title1">拼团商品<span class="tips">未成团，退款中</span></h3>
	                <?php }elseif($OrderDetail['result']['source'] !=5 && $OrderDetail['result']['isSuccess'] ==2 && $OrderDetail['result']['refPriStatus'] ==2){?>
	                <h3 class="title1">拼团商品<span class="tips">未成团，退款成功</span></h3>
	                <?php }elseif($OrderDetail['result']['source'] ==5 && $OrderDetail['result']['orderStatus'] ==10 ){?>
                    <h3 class="title1">拼团商品<span class="tips">已成团，待发货</span></h3>
                    <?php }elseif($OrderDetail['result']['source'] ==5 && $OrderDetail['result']['orderStatus'] ==1  ){?>               
                    <h3 class="title1">拼团商品<span class="tips">待支付</span></h3>
                    <?php }elseif($OrderDetail['result']['source'] ==5 && $OrderDetail['result']['orderStatus'] ==11 ){?>
                    <h3 class="title1">拼团商品<span class="tips">待收货</span></h3>
                    <?php }elseif($OrderDetail['result']['source'] ==5 && $OrderDetail['result']['orderStatus'] ==2  ){?>
                    <h3 class="title1">拼团商品<span class="tips">拼团中</span></h3>
                    <?php }elseif($OrderDetail['result']['source'] ==5 && $OrderDetail['result']['orderStatus'] ==5 ){?>
                    <h3 class="title1">拼团商品<span class="tips">交易已取消</span></h3>
                    <?php }elseif($OrderDetail['result']['source'] ==5 && $OrderDetail['result']['orderStatus'] ==9 ){?>
                    <h3 class="title1">拼团商品<span class="tips">已签收</span></h3>
                    <?php }elseif($OrderDetail['result']['source'] ==5 && $OrderDetail['result']['orderStatus'] ==3 ){?>
	                <h3 class="title1">拼团商品<span class="tips">未成团，退款中</span></h3>
	                <?php }elseif($OrderDetail['result']['source'] ==5 && $OrderDetail['result']['orderStatus'] ==4 ){?>
	                <h3 class="title1">拼团商品<span class="tips">未成团，退款成功</span></h3>
	                <?php }elseif($OrderDetail['result']['source'] ==5 && $OrderDetail['result']['orderStatus'] ==6 ){?>
	                <h3 class="title1">拼团商品<span class="tips">未中奖，返款中</span></h3>
	                <?php }elseif($OrderDetail['result']['source'] ==5 && $OrderDetail['result']['orderStatus'] ==7 ){?>
	                <h3 class="title1">拼团商品<span class="tips">未中奖，返款成功</span></h3>
                    <?php }?>
                    <ul class="list-container">
                        <li><a href="/groupon.php?act=guess&id=<?php echo $OrderDetail['result']['activityId'];?>&pid=<?php echo $OrderDetail['result']['productInfo']['productId'];?>">
                            <div class="img"><img src="<?php echo $OrderDetail['result']['productInfo']['productImage'];?>"></div>
                            <div class="info">
                                <div class="name"><?php echo $OrderDetail['result']['productInfo']['productName'];?></div>
                               <div class="sub">共<?php echo $OrderDetail['result']['productInfo']['number'];?>件商品&nbsp;合计：<font class="themeColor">￥<span class="price"><?php echo $OrderDetail['result']['productInfo']['allPrice'];?></span></font>（免运费）</div>
                            </div>
                        </a></li>
                    </ul>
                   <?php if($OrderDetail['result']['source'] !=5){?>
                    <div class="option">
                     <?php if($OrderDetail['result']['orderStatus'] !=1){?>
                       <?php if($OrderDetail['result']['isSuccess'] ==0 && $OrderDetail['result']['orderStatus'] ==2){?>
                           <a href="groupon_join.php?aid=<?php echo $OrderDetail['result']['attendId']; ?>">查看团详情</a>
                      <?php }else if($OrderDetail['result']['orderStatus'] ==3 ){?>                  
                           <?php if($OrderDetail['result']['source'] !=4 && $OrderDetail['result']['source'] !=3){?>
                           <a href="groupon_join.php?aid=<?php echo $OrderDetail['result']['attendId']; ?>" class="gray">查看团详情</a>
                           <?php }?>
                           <?php if($OrderDetail['result']['refundStatus'] ==0 ){?>
                           <a href="aftersale.php?act=apply&oid=<?php echo $OrderDetail['result']['orderInfo']['orderId'];?>">申请退款</a>
                           <?php }else if($OrderDetail['result']['refundStatus'] ==1){?>
                           <a class="txt">售后申请中...</a>
                           <?php }?>
                      <?php }else if($OrderDetail['result']['orderStatus'] ==4){?>
						    <a href="groupon_join.php?aid=<?php echo $OrderDetail['result']['attendId']; ?>">查看团详情</a>
					  <?php }else if( $OrderDetail['result']['isSuccess'] ==2 && ($OrderDetail['result']['refPriStatus'] ==1) || ($OrderDetail['result']['refPriStatus'] ==0)){?>
						    <a href="groupon_join.php?aid=<?php echo $OrderDetail['result']['attendId']; ?>">查看团详情</a>
				       <?php }else if($OrderDetail['result']['isSuccess'] ==2 && $OrderDetail['result']['refPriStatus'] ==2){?>
						    <a href="groupon_join.php?aid=<?php echo $OrderDetail['result']['attendId']; ?>">查看团详情</a>
					   <?php }else if($OrderDetail['result']['isSuccess'] ==1 && $OrderDetail['result']['orderStatus'] ==2){?>
						    <a href="groupon_join.php?aid=<?php echo $OrderDetail['result']['attendId']; ?>">查看团详情</a>
				      <?php }?>
                    <?php }?>
                    </div>
                   <?php }else{?> 
	                  <div class="option">
	                    <?php if($OrderDetail['result']['orderStatus'] ==2){?>
	                       <a href="groupon_join.php?aid=<?php echo $OrderDetail['result']['attendId']; ?>">查看团详情</a>
	                    <?php }else if($OrderDetail['result']['orderStatus'] ==3){?>
	                       <a href="lottery_new.php?act=winning&aid=<?php echo $OrderDetail['result']['activityId']; ?>&attId=<?php echo $OrderDetail['result']['attendId']; ?>">查看中奖记录</a>
	                       <a href="groupon_join.php?aid=<?php echo $OrderDetail['result']['attendId']; ?>">查看团详情</a>
	                    <?php }else if($OrderDetail['result']['orderStatus'] ==4){?>
	                       <a href="lottery_new.php?act=winning&aid=<?php echo $OrderDetail['result']['activityId']; ?>&attId=<?php echo $OrderDetail['result']['attendId']; ?>">查看中奖记录</a>
	                       <a href="groupon_join.php?aid=<?php echo $OrderDetail['result']['attendId']; ?>">查看团详情</a>
	                    <?php }else if($OrderDetail['result']['orderStatus'] ==5){?>
	                       <a href="lottery_new.php?act=winning&aid=<?php echo $OrderDetail['result']['activityId']; ?>&attId=<?php echo $OrderDetail['result']['attendId']; ?>">查看中奖记录</a>
	                    <?php }else if($OrderDetail['result']['orderStatus'] ==6){?>
	                       <a href="lottery_new.php?act=winning&aid=<?php echo $OrderDetail['result']['activityId']; ?>&attId=<?php echo $OrderDetail['result']['attendId']; ?>">查看中奖记录</a>
	                       <a href="groupon_join.php?aid=<?php echo $OrderDetail['result']['attendId']; ?>">查看团详情</a>
	                    <?php }else if($OrderDetail['result']['orderStatus'] ==7){?>
	                       <a href="lottery_new.php?act=winning&aid=<?php echo $OrderDetail['result']['activityId']; ?>&attId=<?php echo $OrderDetail['result']['attendId']; ?>">查看中奖记录</a>
	                       <a href="groupon_join.php?aid=<?php echo $OrderDetail['result']['attendId']; ?>">查看团详情</a>
	                    <?php }else if($OrderDetail['result']['orderStatus'] ==8){?>
	                       <a href="lottery_new.php?act=winning&aid=<?php echo $OrderDetail['result']['activityId']; ?>&attId=<?php echo $OrderDetail['result']['attendId']; ?>">查看中奖记录</a>
	                       <a href="groupon_join.php?aid=<?php echo $OrderDetail['result']['attendId']; ?>">查看团详情</a>
	                    <?php }else if($OrderDetail['result']['orderStatus'] ==9){?>
	                       <a href="lottery_new.php?act=winning&aid=<?php echo $OrderDetail['result']['activityId']; ?>&attId=<?php echo $OrderDetail['result']['attendId']; ?>">查看中奖记录</a>
	                       <a href="groupon_join.php?aid=<?php echo $OrderDetail['result']['attendId']; ?>">查看团详情</a>   
	                    <?php }else if($OrderDetail['result']['orderStatus'] ==10 ){?>
                           <a href="lottery_new.php?act=winning&aid=<?php echo $OrderDetail['result']['activityId']; ?>&attId=<?php echo $OrderDetail['result']['attendId']; ?>">查看中奖记录</a>
                           <a href="groupon_join.php?aid=<?php echo $OrderDetail['result']['attendId']; ?>">查看团详情</a>
	                    <?php }else if($OrderDetail['result']['orderStatus'] ==11){?>
	                       <a href="lottery_new.php?act=winning&aid=<?php echo $OrderDetail['result']['activityId']; ?>&attId=<?php echo $OrderDetail['result']['attendId']; ?>">查看中奖记录</a>
	                       <a href="groupon_join.php?aid=<?php echo $OrderDetail['result']['attendId']; ?>">查看团详情</a>
	                       <?php if($OrderDetail['result']['refundStatus'] ==0 ){?>
                           <a href="aftersale.php?act=apply&oid=<?php echo $OrderDetail['result']['orderInfo']['orderId'];?>">申请退款</a>
                           <?php }else if($OrderDetail['result']['refundStatus'] ==1){?>
                           <a class="txt">售后申请中...</a>
                           <?php }?>
	                    <?php }?>
	                   </div>
                    <?php }?>
                </section>

                <section class="oc-info">
                    <div>订单编号：<?php echo $OrderDetail['result']['orderInfo']['orderNo'];?></div>
                    
                    <?php if($OrderDetail['result']['orderInfo']['paymethod'] ==1){?>
                    <div>支付方式：支付宝</div>
                    <?php }else if($OrderDetail['result']['orderInfo']['paymethod'] ==2){?>
                    <div>支付方式：微信支付</div>
                    <?php }else if($OrderDetail['result']['orderInfo']['paymethod'] ==8){?>
                    <div>支付方式：微信支付</div>
                    <?php }?>
                    <div>下单时间：<?php echo $OrderDetail['result']['orderInfo']['createTime'];?></div>
                    <?php if($OrderDetail['result']['source'] !=5 && $OrderDetail['result']['orderStatus'] ==2  && $OrderDetail['result']['isSuccess'] ==1){?>
                    <div>成团时间：<?php echo $OrderDetail['result']['orderInfo']['groupTime'];?></div>
                    <?php }elseif($OrderDetail['result']['source'] !=5 && $OrderDetail['result']['orderStatus'] ==3){?>
                     <div>成团时间：<?php echo $OrderDetail['result']['orderInfo']['groupTime'];?></div>
                    <?php }elseif($OrderDetail['result']['source'] ==5 && ($OrderDetail['result']['orderStatus'] ==6) || ($OrderDetail['result']['orderStatus'] ==7) || ($OrderDetail['result']['orderStatus'] ==9) || ($OrderDetail['result']['orderStatus'] ==10) || ($OrderDetail['result']['orderStatus'] ==11)){?>
                    <div>成团时间：<?php echo $OrderDetail['result']['orderInfo']['groupTime'];?></div>
                    <?php }elseif($OrderDetail['result']['source'] !=5 && $OrderDetail['result']['orderStatus'] ==4){?>
                     <div>成团时间：<?php echo $OrderDetail['result']['orderInfo']['groupTime'];?></div>
                     <div>发货时间：<?php echo $OrderDetail['result']['orderInfo']['sendTime'];?></div>
                     <div>成交时间：<?php echo $OrderDetail['result']['orderInfo']['confirmTime'];?></div>
                     <div>快递方式：<?php echo $OrderDetail['result']['orderInfo']['logisticsName'];?></div>
                     <div>运单编号：<?php echo $OrderDetail['result']['orderInfo']['logisticsNo'];?></div>
                    <?php }?>
                </section>
          <?php if($OrderDetail['result']['orderStatus'] ==1 && $OrderDetail['result']['isCancel'] ==0){?>
                <section class="oc-pay">
                    <ul class="list">
                        <li>
                            <input type="radio" name="payWay" checked />
                            <img src="images/pay-wx.png" />
                            <p>微信支付</p>
                            <span class="label">推荐</span>
                        </li>
                        <!--  <li>
                            <input type="radio" name="payWay" />
                            <img src="images/pay-zfb.png" />
                            <p>支付宝支付</p>
                        </li>
                        <li>
                            <input type="radio" name="payWay" />
                            <img src="images/pay-qq.png" />
                            <p>QQ钱包</p>
                        </li>-->
                    </ul>
                </section>
             <?php }?>
             
            
            </div>
          <?php if($OrderDetail['result']['source'] !=5){?>
            <div class="oc-footer2">
            	<?php if($OrderDetail['result']['orderStatus'] ==1 && $OrderDetail['result']['isCancel'] ==0){?>
                    <!-- <a class="one" id="orderCancel"> href="order_detail.php?act=cancel&oid=<?php echo $OrderDetail['result']['orderId'] ;?>">取消订单</a> -->
                    <a class="btn gray" id="orderCancel">取消订单</a>
                    <a class="btn" href="/wxpay/pay.php?oid=<?php echo $OrderDetail['result']['orderInfo']['orderId'] ;?>">去支付</a>
              <?php }else if($OrderDetail['result']['orderStatus'] ==3){?>
                    <a href="logistics.php?oid=<?php echo $OrderDetail['result']['orderInfo']['orderId'];?>" class="btn gray">查看物流</a>
                   <?php if($OrderDetail['result']['refundStatus'] ==0 || $OrderDetail['result']['refundStatus'] ==6 || $OrderDetail['result']['refundStatus'] ==5){?>
                    <a id="check" class="btn" data-id="<?php echo $OrderDetail['result']['orderInfo']['orderId'] ;?>" data-status="<?php echo $OrderDetail['result']['orderStatus']  ;?>">确认收货</a>
                   <?php }else if($OrderDetail['result']['refundStatus'] ==1){?>
                    <a class="txt">售后申请中...</a>
                   <?php }?>
             <?php }else if($OrderDetail['result']['orderStatus'] ==4){?>
                     <a href="logistics.php?oid=<?php echo $OrderDetail['result']['orderInfo']['orderId'];?>" class="btn">查看物流</a>
             <?php }?>
            </div>
		<?php }else{?>
			<div class="oc-footer2">
	            	<?php if($OrderDetail['result']['orderStatus'] ==1 && $OrderDetail['result']['isCancel'] ==0){?>
	                    <a class="btn gray" id="orderCancel">取消订单</a>
	                    <a class="btn" href="/wxpay/pay.php?oid=<?php echo $OrderDetail['result']['orderInfo']['orderId'] ;?>">去支付</a>
	              <?php }else if($OrderDetail['result']['orderStatus'] ==11){?>
	                    <a href="logistics.php?oid=<?php echo $OrderDetail['result']['orderInfo']['orderId'];?>" class="btn gray">查看物流</a>
	                   <?php if($OrderDetail['result']['refundStatus'] ==0 || $OrderDetail['result']['refundStatus'] ==6 || $OrderDetail['result']['refundStatus'] ==5){?>
	                    <a id="check" class="btn" data-id="<?php echo $OrderDetail['result']['orderInfo']['orderId'] ;?>" data-status="<?php echo $OrderDetail['result']['orderStatus']  ;?>">确认收货</a>
	                   <?php }else if($OrderDetail['result']['refundStatus'] ==1){?>
	                    <a class="txt">售后申请中...</a>
	                   <?php }?>
	             <?php }else if($OrderDetail['result']['orderStatus'] ==9){?>
	                     <a href="logistics.php?oid=<?php echo $OrderDetail['result']['orderInfo']['orderId'];?>" class="btn">查看物流</a>
	             <?php }?>
	            </div>
		<?php }?>
            <script>
                $(document).on("pageInit", "#page-orderCofirm", function(e, pageId, page) {
                    $("#orderCancel").on("click", function(){
                    	var _this = $(this);
	                	$.confirm("是否取消订单？", function(){
	                        $.post("order_detail.php",{act: "cancel", oid:"<?php echo $OrderDetail['result']['orderInfo']['orderId'] ;?>"},function(req){
	                        	req =  eval("(" + req + ")");;
	                            $.toast(req.data.data.error_msg);
	                            history.back(-1);
	                        },"JSON");
	                	})
                    });
                })
                $(document).on("click", "#check", function(){
	                var _this = $(this);
                	$.confirm("是否确定收货？", function(){
	                    $.post("order_detail.php",{act: "edit", oid:_this.attr("data-id"), status:_this.attr("data-status")},function(req){
	                    	req =  eval("(" + req + ")");;
	                        $.toast(req.data.data.error_msg);
							history.back(-1);
	                    },"JSON");
                	});
                });
            </script>

        </div>
    </div>

</body>

</html>

<?php include_once('header_notice_web.php');?>
<?php include_once('wxshare_web.php');?>
<body>
<div class="page-group" id="page-orderCofirm">
    <div id="page-nav-bar" class="page page-current">
        <header class="bar bar-nav">
            <a class="button button-link button-nav pull-left back" href="javascript:history.back(-1);">
                <span class="icon icon-back"></span>
            </a>
            <h1 class="title"><?php echo $statusTitle;?></h1>
        </header>

        <div class="content native-scroll" style="bottom:2.75rem;">
            <div class="oc-state">
                <span><?php echo $statusState;?></span>
                <i class="o-icon o-icon-<?php echo $statusImg;?>"></i>
            </div>

            <section class="oc-adress oc-adress-disable">
                <a>
                    <div><?php echo $OrderDetail['result']['addressInfo']['consignee'];?></div>
                    <div><?php echo $OrderDetail['result']['addressInfo']['tel'];?></div>
                    <div><?php echo $OrderDetail['result']['addressInfo']['address'];?></div>
                </a>
            </section>

            <section class="freeList proTips-2 oc-pro">

                <h3 class="title1">拼团商品<span class="tips"><?php echo $statusTips;?></span></h3>

                <ul class="list-container">
                    <li><a href="/groupon.php?act=guess&id=<?php echo $OrderDetail['result']['activityId'];?>&pid=<?php echo $OrderDetail['result']['productInfo']['productId'];?>">
                            <div class="img"><img src="<?php echo $OrderDetail['result']['productInfo']['productImage'];?>"></div>
                            <div class="info">
                                <div class="name"><?php echo $OrderDetail['result']['productInfo']['productName'];?></div>
                                <div class="sub">共<?php echo $OrderDetail['result']['productInfo']['number'];?>件商品&nbsp;合计：<font class="themeColor">￥<span class="price"><?php echo $OrderDetail['result']['productInfo']['allPrice'];?></span></font>（免运费）</div>
                            </div>
                        </a></li>
                </ul>
                <?php if($OrderDetail['result']['source'] != 5 && $OrderDetail['result']['source'] != 7){?>
                    <div class="option">
                        <?php if($OrderDetail['result']['orderStatus'] !=1){?>
                            <?php if ($OrderDetail['result']['orderStatus'] ==3) { //已发货状态 ?>
                                <?php if($OrderDetail['result']['refundStatus'] ==0 ){ //未申请过售后 ?>
                                    <a href="aftersale.php?act=apply&oid=<?php echo $OrderDetail['result']['orderInfo']['orderId'];?>">申请退款</a>
                                <?php } elseif ($OrderDetail['result']['refundStatus'] == 1 || $OrderDetail['result']['refundStatus'] == 2 || $OrderDetail['result']['refundStatus'] == 3) { //申请过售后 ?>
                                    <a class="txt">售后申请中...</a>
                                <?php } else { ?>
                                    <a href="groupon_join.php?aid=<?php echo $OrderDetail['result']['attendId']; ?>" class="gray">查看团详情</a>
                                <?php } ?>
                            <?php } ?>
                        <?php }?>
                    </div>
                <?php } else { ?>
                    <div class="option">
                        <?php if($OrderDetail['result']['orderStatus'] != 2 || $OrderDetail['result']['orderStatus'] != 1) { //待支付 拼团中,不显示中奖记录 ?>
                            <a href="lottery_new.php?act=winning&aid=<?php echo $OrderDetail['result']['activityId']; ?>&attId=<?php echo $OrderDetail['result']['attendId']; ?>&type=<?php if($OrderDetail['result']['source']==5){?>5<?php }elseif($OrderDetail['result']['source']==7){?>7<?php }?>">查看中奖记录</a>
                        <?php } ?>
                        <a href="groupon_join.php?aid=<?php echo $OrderDetail['result']['attendId']; ?>">查看团详情</a>
                        <?php if ($OrderDetail['result']['source']==5) { ?>
                            <?php if ($OrderDetail['result']['orderStatus'] ==11) { ?>
                                <a href="aftersale.php?act=apply&oid=<?php echo $OrderDetail['result']['orderInfo']['orderId'];?>">申请退款</a>
                            <?php } ?>
                            <?php if ($OrderDetail['result']['refundStatus'] ==1 || $OrderDetail['result']['refundStatus'] ==2 || $OrderDetail['result']['refundStatus'] ==3) { ?>
                                <a class="txt">售后申请中...</a>
                            <?php } ?>
                        <?php } ?>
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
                <?php if($OrderDetail['result']['source'] !=5 && $OrderDetail['result']['source'] !=7 && $OrderDetail['result']['orderStatus'] ==2  && $OrderDetail['result']['isSuccess'] ==1){?>
                    <div>成团时间：<?php echo $OrderDetail['result']['orderInfo']['groupTime'];?></div>
                <?php }elseif($OrderDetail['result']['source'] !=5 && $OrderDetail['result']['source'] !=7 && $OrderDetail['result']['orderStatus'] ==3){?>
                    <div>成团时间：<?php echo $OrderDetail['result']['orderInfo']['groupTime'];?></div>
                <?php }elseif((($OrderDetail['result']['source'] ==5) || ($OrderDetail['result']['source'] ==7)) && (($OrderDetail['result']['orderStatus'] ==6) || ($OrderDetail['result']['orderStatus'] ==7) || ($OrderDetail['result']['orderStatus'] ==9) || ($OrderDetail['result']['orderStatus'] ==10) || ($OrderDetail['result']['orderStatus'] ==11))){?>
                    <div>成团时间：<?php echo $OrderDetail['result']['orderInfo']['groupTime'];?></div>
                <?php }elseif(($OrderDetail['result']['orderStatus'] ==4) || ($OrderDetail['result']['orderStatus'] ==9)){?>
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
        <?php if($OrderDetail['result']['source'] !=5 && $OrderDetail['result']['source'] !=7){?>
            <div class="oc-footer2">
                <?php if($OrderDetail['result']['orderStatus'] ==1 && $OrderDetail['result']['isCancel'] ==0){?>
                    <!-- <a class="one" id="orderCancel"> href="order_detail.php?act=cancel&oid=<?php echo $OrderDetail['result']['orderId'] ;?>">取消订单</a> -->
                    <a class="btn gray" id="orderCancel">取消订单</a>
                    <a class="btn" href="/wxpay/pay.php?oid=<?php echo $OrderDetail['result']['orderInfo']['orderId'] ;?>">去支付</a>
                <?php }else if($OrderDetail['result']['orderStatus'] ==3){?>
                    <a href="logistics.php?oid=<?php echo $OrderDetail['result']['orderInfo']['orderId'];?>" class="btn gray">查看物流</a>
                    <?php if($OrderDetail['result']['refundStatus'] ==0 || $OrderDetail['result']['refundStatus'] ==6 || $OrderDetail['result']['refundStatus'] ==5){?>
                        <a id="check" class="btn" data-id="<?php echo $OrderDetail['result']['orderInfo']['orderId'] ;?>" data-status="<?php echo $OrderDetail['result']['orderStatus']  ;?>">确认收货</a>
                    <?php }else if($OrderDetail['result']['refundStatus'] ==1 || $OrderDetail['result']['refundStatus'] ==2 || $OrderDetail['result']['refundStatus'] ==3){?>
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
                    <?php }else if($OrderDetail['result']['refundStatus'] ==1 || $OrderDetail['result']['refundStatus'] ==2 || $OrderDetail['result']['refundStatus'] ==3){?>
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
                            req =  eval("(" + req + ")");
                            $.toast(req.data.data.error_msg);
                            history.back(-1);
                        },"JSON");
                    })
                });
            });
            $(document).on("click", "#check", function(){
                var _this = $(this);
                $.confirm("是否确定收货？", function(){
                    $.post("order_detail.php",{act: "edit", oid:_this.attr("data-id"), status:_this.attr("data-status")},function(req){
                        req =  eval("(" + req + ")");
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
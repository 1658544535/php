<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>淘竹马</title>
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
    <div class="page-group" id="page-orderCofirm">
        <div id="page-nav-bar" class="page page-current">
            <header class="bar bar-nav">
                <a class="button button-link button-nav pull-left back" href="">
                    <span class="icon icon-back"></span>
                </a>
                <h1 class="title">确认订单</h1>
            </header>
          <div class="content native-scroll" style="bottom:2.75rem;">
                <?php if($OrderDetail['result']['orderStatus'] ==2){?>
                <div class="oc-state"><span>拼团成功，等待卖家发货！</span><i class="o-icon o-icon-1"></i></div>
                <?php }elseif($OrderDetail['result']['orderStatus'] ==1){?>
                <div class="oc-state"><span>等待买家付款</span><i class="o-icon o-icon-2"></i></div>
                <?php }elseif($OrderDetail['result']['orderStatus'] ==3){?>
                <div class="oc-state"><span>卖家已发货，还剩 N 小时自动确认</span><i class="o-icon o-icon-3"></i></div>
                <?php }elseif($OrderDetail['result']['orderStatus'] ==0){?>
<!--                 <div class="oc-state"><span>拼团还未成功，赶快召唤小伙伴！</span><i class="o-icon o-icon-4"></i></div> -->
                <?php }elseif($OrderDetail['result']['orderStatus'] ==0){?>
<!--                 <div class="oc-state"><span>交易已取消</span><i class="o-icon o-icon-5"></i></div> -->
                <?php }elseif($OrderDetail['result']['orderStatus'] ==5){?>
                <div class="oc-state"><span>交易成功！</span><i class="o-icon o-icon-6"></i></div>
                <?php }elseif($OrderDetail['result']['product'][0]['reStatus'] ==4){?>
                <div class="oc-state"><span>未成团，退款成功！</span><i class="o-icon o-icon-7"></i></div>
                <?php }elseif($OrderDetail['result']['product'][0]['reStatus'] ==3){?>
                <div class="oc-state"><span>未成团，退款中！</span><i class="o-icon o-icon-8"></i></div>
                <?php }?>
            


                <div class="oc-tips">当然地址不在配送范围内</div>

                <section class="oc-adress">
                    <a href="#">
                        <div><?php echo $OrderDetail['result']['name'];?>&nbsp;&nbsp;&nbsp;<?php echo $OrderDetail['result']['tel'];?></div>
                        <div><?php echo $OrderDetail['result']['address'];?></div>
                    </a>
                </section>

                <section class="freeList proTips-2 oc-pro">
                    <h3 class="title1">拼团商品</h3>
                    <ul class="list-container">
                        <li><a href="#">
                            <div class="img"><img src="<?php echo $OrderDetail['result']['product'][0]['productImage'];?>"></div>
                            <div class="info">
                                <div class="name"><?php echo $OrderDetail['result']['product'][0]['productName'];?></div>
                            </div>
                        </a></li>
                    </ul>
                    <div class="subTotal">共<?php echo $OrderDetail['result']['product'][0]['productNumber'];?>件商品&nbsp;合计：<font class="themeColor">￥<span class="price"><?php echo $OrderDetail['result']['product'][0]['price'];?></span></font>（免运费）</div>
                </section>

                <section class="oc-info">
                    <div>订单编号：<?php echo $OrderDetail['result']['orderNumber'];?></div>
                    <div>支付方式：微信</div>
                    <div>下单时间：<?php echo $OrderDetail['result']['addtime'];?></div>
                </section>
          <?php if($OrderDetail['result']['orderStatus'] ==1){?>
                <section class="oc-pay">
                    <ul class="list">
                        <li>
                            <input type="radio" name="payWay" checked />
                            <img src="images/pay-wx.png" />
                            <p>微信支付</p>
                            <span class="label">推荐</span>
                        </li>
                        <li>
                            <input type="radio" name="payWay" />
                            <img src="images/pay-zfb.png" />
                            <p>支付宝支付</p>
                        </li>
                        <li>
                            <input type="radio" name="payWay" />
                            <img src="images/pay-qq.png" />
                            <p>QQ钱包</p>
                        </li>
                    </ul>
                </section>
             <?php }?>
             
            
            </div>

            <div class="deta-footer">
                <a class="goIndex" href="index.html">
                    <span class="icon i-home"></span>
                    <span class="tab-label">首页</span>
                </a>
                <?php if($OrderDetail['result']['orderStatus'] ==1){?>
                <div class="buy">
                    <a class="one" href="#" data-type="">取消订单</a>
                    <a class="more" href="#">去支付</a>
                </div>
           <?php }?>
            </div>

        </div>
    </div>

</body>

</html>

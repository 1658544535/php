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
	<form action="order.php" method="post" onsubmit="return submitPay()">
		<div class="page-group" id="page-orderCofirm">
			<div id="page-nav-bar" class="page page-current">
				<header class="bar bar-nav">
					<a class="button button-link button-nav pull-left back" href="javascript:history.back(-1);">
						<span class="icon icon-back"></span>
					</a>
					<h1 class="title">确认订单</h1>
				</header>

				<div class="content native-scroll" style="bottom:2.75rem;">
					<?php if(!$canDispatch){ ?>
						<div class="oc-tips themeColor">当前地址不在配送范围内</div>
					<?php } ?>

					<section class="oc-adress">
						<a href="/address?act=choose">
							<?php if ( $address == NULL ){ ?>
								<div>您的地址信息为空，点击进行添加</div>
							<?php }else{ ?>
								<div><?php echo $address['name']; ?>&nbsp;&nbsp;&nbsp;<?php echo $address['tel']; ?></div>
								<div><?php if(!$canDispatch){ ?><strong>（无法配送至该地址）</strong><?php } ?><?php echo $address['address']; ?></div>
							<?php } ?>
						</a>
					</section>

					<?php
					if($_SESSION['order']['type'] == 'guess'){
						$tipTitle = '拼团商品';
						$tipPrice = '拼团价';
					}else{
						$tipTitle = '拼团商品';
						$tipPrice = '拼团价';
					}
					?>

					<section class="freeList proTips-2 oc-pro">
						<h3 class="title1"><?php echo $tipTitle;?></h3>
						<ul class="list-container">
							<li><a href="groupon.php?id=<?php echo $grouponId;?>">
								<div class="img"><img src="<?php echo $info['products']['productImage'];?>"></div>
								<div class="info">
									<div class="name"><?php echo $info['products']['productName'];?></div>
									<div class="price">
										<div class="btn">商品详情</div>
										<?php echo $tipPrice;?>：<span class="price1" id="price"><?php echo $info['products']['price'];?></span>
										<span class="price2">￥<?php echo $info['products']['sellingPrice'];?></span>
									</div>
								</div>
							</a></li>
						</ul>
						<input type="hidden" name="skuid" value="<?php echo $info['products']['skuLinkId'];?>" />
						<?php if(!in_array($_SESSION['order']['type'], array('free', 'guess'))){ ?>
						<div class="num">
							<span class="label">数量</span>
							<div class="quantity">
								<span class="minus">-</span>
								<input type="text" id="number" name="num" value="<?php echo $info['allCount'];?>" />
								<span class="plus">+</span>
							</div>
						</div>
						<?php } ?>
						<div class="subTotal">合计：<font class="themeColor">￥<span class="price" id="totol-amount"><?php echo $info['sumPrice'];?></span></font>（全场包邮）</div>
					</section>

	                <section class="oc-coupon">
	                    <div>使用优惠券：</div>
	                    <div>券码<b id="coupon-number">123456789</b></div>
	                    <span class="price">优惠<b id="coupon-price">1</b>元</span>
	                </section>

					<section class="oc-pay">
						<ul class="list">
							<li>
								<input type="radio" name="payWay" checked />
								<img src="images/pay-wx.png" />
								<p>微信支付</p>
								<span class="label">推荐</span>
							</li>
						</ul>
					</section>

				</div>

				<div class="oc-footer">
					实付款：<font class="themeColor">￥<span class="price" id="fact-amount"><?php echo $info['sumPrice'];?></span></font>
					<input type="submit" value="立即支付" class="btn<?php if(!$canDispatch){ ?> gray<?php } ?>" />
				</div>
			</div>
	        <div class="popup popup-oc-coupon">
	            <div>
	                <a href="#" class="close-popup"></a>
	                <ul>
	                    <li>
	                        <div class="freeCoupon" data-number="123456789" data-price="10">
	                            <div class="info">
	                                <div class="name">团长免单券 <span>(团长免费开团)</span></div>
	                                <div class="tips">点击选择团免商品</div>
	                                <div class="time">有效期: 2016.9.15-2016.9.22</div>
	                            </div>
	                            <div class="price"><div>￥<span>10</span></div></div>
	                        </div>
	                    </li>
	                    <li>
	                        <div class="freeCoupon" data-number="987654321" data-price="20">
	                            <div class="info">
	                                <div class="name">团长免单券 <span>(团长免费开团)</span></div>
	                                <div class="tips">点击选择团免商品</div>
	                                <div class="time">有效期: 2016.9.15-2016.9.22</div>
	                            </div>
	                            <div class="price"><div>￥<span>20</span></div></div>
	                        </div>
	                    </li>
	                    <li>
	                        <div class="freeCoupon" data-number="456789123" data-price="30">
	                            <div class="info">
	                                <div class="name">团长免单券 <span>(团长免费开团)</span></div>
	                                <div class="tips">点击选择团免商品</div>
	                                <div class="time">有效期: 2016.9.15-2016.9.22</div>
	                            </div>
	                            <div class="price"><div>￥<span>30</span></div></div>
	                        </div>
	                    </li>
	                </ul>
	            </div>
	        </div>
		</div>
	</form>

	<script type="text/javascript">
	$(document).on("pageInit", "#page-orderCofirm", function(e, pageId, page) {
		priceTotal();
    	//数量增减
    	$(".quantity .minus").on("click", function(){
    		var num = parseInt($(this).next().val());
    		if(num>1){
    			$(this).next().val(--num);
    		}else{
    			return false;
    		}
    		priceChange();
    	});
    	$(".quantity .plus").on("click", function(){
    		var num = parseInt($(this).prev().val());
    		$(this).prev().val(++num)
    		priceChange();
    	});
    	$(".popup-oc-coupon .freeCoupon").on("click", function(){
    		var number = $(this).attr("data-number"),
    			price = $(this).attr("data-price");
    		$("#coupon-number").html(number);
    		$("#coupon-price").html(price);
    		$.closeModal('.popup-oc-coupon');
    		priceTotal();
    	});

		function priceChange(){
			var num = parseInt($("#number").val());
			var price = parseFloat($("#price").html());
			$("#totol-amount,#fact-amount").html(parseFloat(num*price).toFixed(2));
			priceTotal();
		}

		function priceTotal(){
			var totalPrice = parseFloat($("#totol-amount").html());
			var couponPrice = parseFloat($("#coupon-price").html());
			totalPrice = totalPrice - couponPrice;
			totalPrice<0 ? totalPrice=0 : '';

			$("#fact-amount").html(totalPrice.toFixed(2));
		}
    });
	function submitPay(e){
		<?php if(empty($address)){ ?>
			$.toast("请设置收货地址");
			return false;
		<?php } ?>

		<?php if(!$canDispatch){ ?>
			return false;
		<?php } ?>
		return true;
	}
	</script>
</body>

</html>

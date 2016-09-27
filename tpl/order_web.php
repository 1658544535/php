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
					<a class="button button-link button-nav pull-left back" href="">
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
							<?php if ( $UserAddressInfo == NULL ){ ?>
								<div>您的地址信息为空，点击进行添加</div>
							<?php }else{ ?>
								<div><?php echo $UserAddressInfo->consignee; ?>&nbsp;&nbsp;&nbsp;<?php echo $UserAddressInfo->consignee_phone; ?></div>
								<div><?php if(!$canDispatch){ ?><strong>（无法配送至该地址）</strong><?php } ?><?php echo $UserAddressInfo->desc; ?></div>
							<?php } ?>
						</a>
					</section>

					<section class="freeList proTips-2 oc-pro">
						<h3 class="title1">拼团商品</h3>
						<ul class="list-container">
							<li><a href="groupon.php?id=<?php echo $grouponId;?>">
								<div class="img"><img src="<?php echo $site_image;?>product/<?php echo $Product->image_small;?>"></div>
								<div class="info">
									<div class="name"><?php echo $product['product_name'];?></div>
									<div class="price">
										<div class="btn">商品详情</div>
										拼团价：<span class="price1"><?php echo $factOrderPrice;?></span>
										<span class="price2">￥<?php echo $product['order_price'];?></span>
									</div>
								</div>
							</a></li>
						</ul>
						<?php if(!in_array($_SESSION['order']['type'], array('free', 'guess')){ ?>
						<div class="num">
							<span class="label">数量</span>
							<div class="quantity">
								<span class="minus">-</span>
								<input type="text" name="num" value="1" />
								<span class="plus">+</span>
							</div>
						</div>
						<?php } ?>
						<div class="subTotal">合计：<font class="themeColor">￥<span class="price"><?php echo $factOrderPrice;?></span></font>（全场包邮）</div>
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
					实付款：<font class="themeColor">￥<span class="price"><?php echo $factOrderPrice;?></span></font>
					<input type="submit" value="立即支付" class="btn<?php if(!$canDispatch){ ?> gray<?php } ?>" />
					<?php /* ?><a class="btn<?php if(!$canDispatch){ ?> gray<?php } ?>" href="">立即支付</a><?php */ ?>
				</div>
			</div>
		</div>
	</form>

	<script type="text/javascript">
	function submitPay(){
		<?php if($UserAddressInfo == NULL){ ?>
			$.toast("请设置收货地址");
			return false;
		<?php } ?>
		return true;
	}
	</script>
</body>

</html>

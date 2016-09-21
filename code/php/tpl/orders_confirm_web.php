<!doctype html>
<html lang="zh">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1, user-scalable=no" />
<meta content="telephone=no" name="format-detection" />
<title><?php echo $site_name;?></title>
<link href="/css/common.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="/js/jquery-1.11.0.min.js"></script>
<script type="text/javascript" src="/js/jquery.cycle.all.js"></script>
<script src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>
<script type="text/javascript" src="/js/wxshare.js"></script>
<script>
	wxshare( <?php echo WXJSDEBUG;?>, '<?php echo WXJSAPPID;?>', <?php echo WXJSTIMESTAMP;?>, '<?php echo WXJSNONCESTR;?>', '<?php echo WXJSSIGNATURE;?>', '<?php echo WEBLOGO;?>', '<?php echo $SHARP_URL;?>', '<?php echo WEBTITLE;?>', '<?php echo WEBDESC;?>' )
</script>
</head>

<body>
<div id="header">
	<a href="/cart?return_url=/;" class="header_back"></a>
	<p class="header_title">确认订单</p>
</div>

<form action="orders" method='post' onsubmit="return submitPay()">
	<input type="hidden"  name="act" value="add_save" />
	<div class="order_info_warp">
		<img style="display:block;margin-top:10px;" src="/images/order/address_line.png" />
		<div class="address_warp">
			<a href="/address?act=choose">
				<?php if ( $UserAddressInfo == NULL ){ ?>
					<p style="margin:15px 20px;" >请新建收货地址以确保商品顺利到达</p>
				<?php }else{ ?>
					<p>
						<span>收货人：<?php echo $UserAddressInfo->consignee; ?></span>
						<span style="text-align:right;"><?php echo $UserAddressInfo->consignee_phone; ?></span>
					</p>
					<p>收货地址：<?php echo $UserAddressInfo->desc; ?></p>
				<?php } ?>
			</a>
		</div>
		<img style="display:block;" src="/images/order/address_line.png" />

		<div class="pay_warp">
			<h3>支付方式</h3>
			<ul>
				<li>
					<a href="/user_info.php?act=coupon&from=order_comfire&return_url=user">使用代金券　<?php echo $CouponPriceTip; ?> </a>

				</li>

				<?php if ( $isCanUseWallet ){ ?>
					<li class="checkbox">
						<input type="checkbox" name="isWallet" />
						<img src="../images/banlance.png" />
						<div class="txt">
							<p>钱包余额：<span>￥<?php echo sprintf( '%.1f', $objUserWalletInfo->balance); ?></span></p>
						</div>
					</li>
				<?php } ?>
			<!--
				<li class="radio">
					<input type="radio" name="pay_way" checked="checked" />
					<img src="../images/tzm299.png" />
					<div class="txt">
						<p>支付宝</p>
						<span>安全快捷，可支持银行卡支付</span>
					</div>
				</li>
			-->
				<li class="radio">
					<input type="radio" name="pay_way" checked="checked" />
					<img src="../images/tzm298.png" />
					<div class="txt">
						<p>微信支付</p>
						<span>推荐已在微信中绑定银行卡的用户使用</span>
					</div>
				</li>
			</ul>
		</div>

		<div class="order_pro_list">
			<ul>
				<?php
				$nOrderAmount   	= 0;					// 全部订单总价
				foreach( $UserCartList['list'] as $k=>$ShopList ){
					foreach( $ShopList['info'] as $ActivityInfo ){
				?>
					<li>
						<?php
							$nAllProductCount 		= 0;		// 单张订单的商品数
							$nProductPriceAmount   	= 0;		// 单张订单的商品总价
							foreach( $ActivityInfo['product'] as $Product ){
								$nAllProductCount 	 += $Product->num;
								$nProductPriceAmount +=	$Product->stock_price * $Product->num;
						?>
							<a href="product_detail?type=3&pid=<?php echo $Product->product_id;?>">
								<table border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td rowspan="2" width="80">
											<img src="<?php echo $site_image;?>product/small/<?php echo $Product->product_image; ?>" />
										</td>
										<td rowspan="2" style="vertical-align:middle;color:#b2b2b2"><?php echo $Product->sku_info->sku_long_desc; ?></td>
										<!-- <td class="order_pro_title"><?php echo $Product->product_name; ?></td> -->
									</tr>
									<tr>
										<td width="50" style="vertical-align:middle;color:#b2b2b2;text-align:right;">
											<p style="color:#db0a25;">￥<?php echo $Product->stock_price; ?></p>
											<span>X<?php echo $Product->num; ?></span>
										</td>
									</tr>
								</table>
							</a>
						<?php } ?>

						<div class="subtotal">
							共 <?php echo $nAllProductCount; ?> 件商品&nbsp;&nbsp;
							实付<span style="color:#db0a25;">￥<?php echo sprintf('%.1f',$nProductPriceAmount); ?></span>
							<!-- &nbsp;(含运费<?php echo sprintf('%.1f',$espress_price); ?>元) -->
						</div>
						<div class="message">
							<input type="text" name="message[<?php echo $k; ?>]" placeholder="给商家留言 （45字以内）：" />
						</div>
					</li>
				<?php
					$nOrderAmount += $nProductPriceAmount;
				}
				?>
				<?php } ?>
			</ul>
		</div>
	</div>

	<div style="height:40px;"></div>
	<div class="shoppingCart-foot" style="bottom:0;border-top:1px solid #ddd;">
		<div class="shoppingCart-foot-R">
			<input name="submit" type="submit" class="shoppingCart-foot-R-btn" style="width:100px;" value="提交订单" />
			<div style="line-height:20px;">
				<p style="color:#f78d1d">总计：￥<span id="t_price" style="color:#f78d1d"><?php echo sprintf('%.1f',$fOrderAllPrice + $espress_price); ?></span></p>
				<p style="color:#b2b2b2">(含运费<?php echo sprintf('%.1f',$espress_price); ?>)</p>
			</div>
		</div>
	</div>
</form>
<?php include "footer_web.php";?>

	<script>
		$(function(){
			pay_way_check();
			wallet_check();
			$(".pay_warp ul li.radio input:radio").on("change",pay_way_check);
			$(".pay_warp ul li.checkbox input:checkbox").on("change",wallet_check);
			function pay_way_check(){
				$(".pay_warp ul li.radio").each(function(index,el){
					if($(el).find("input:radio").is(":checked")){
						$(el).addClass("active");
					}else{
						$(el).removeClass("active");
					}
				});
			}
			function wallet_check(){
				$(".pay_warp ul li.checkbox").each(function(index,el){
					if($(el).find("input:checkbox").is(":checked")){
						$(el).addClass("active");
					}else{
						$(el).removeClass("active");
					}
				});
			}
		});

		function submitPay(){
			<?php if($UserAddressInfo == NULL){ ?>
				alert("请设置收货地址");
				return false;
			<?php } ?>
			return true;
		}
	</script>

</body>
</html>

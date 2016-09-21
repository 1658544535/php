<!doctype html>
<html lang="zh">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1, user-scalable=no" />
<meta content="telephone=no" name="format-detection" />
<title><?php echo $site_name;?></title>

<link href="/css/common.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="/js/jquery-1.11.0.min.js"></script>
<script type="text/javascript" src="js/jquery.cycle.all.js"></script>
<script src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>
<script type="text/javascript" src="/js/wxshare.js"></script>
<script>
	wxshare( <?php echo WXJSDEBUG;?>, '<?php echo WXJSAPPID;?>', <?php echo WXJSTIMESTAMP;?>, '<?php echo WXJSNONCESTR;?>', '<?php echo WXJSSIGNATURE;?>', '<?php echo WEBLOGO;?>', '<?php echo $SHARP_URL;?>', '<?php echo WEBTITLE;?>', '<?php echo WEBDESC;?>' )
</script>
</head>

<body>
	<div id="header">
	    <a href="javascript:history.go(-1);" class="header_back"></a>
	    <p class="header_title">订单详情</p>
	</div>

	<div class="order_info_list">
		<h3>收货人信息</h3>
		<ul>
			<li>
				<label>收货人：</label>
				<div><?php echo $UserAddressInfo->consignee; ?></div>
			</li>
			<li>
				<label>联系电话：</label>
				<div><?php echo $UserAddressInfo->consignee_phone; ?></div>
			</li>
			<li>
				<label>收货地址：</label>
				<div><?php echo $UserAddressInfo->desc; ?></div>
			</li>
		</ul>
	</div>

	<div class="order_pro_list order_list_new">
		<ul>
			<li>
				<h3>
					<a href="javascript:void(0);" style="max-width:100%;width:100%;">
						<?php echo $objOrderInfo['activity_name']; ?>
					</a>
				</h3>
				<?php foreach( $objOrderInfo['info'] as $Product ){ ?>
					<a href="/product_detail?pid=<?php echo $Product['product_id']; ?>&type=<?php echo $objOrderInfo['activity_type']; ?>&aid=<?php echo $objOrderInfo['activity_id'] ;?>">
						<table border="0" cellpadding="0" cellspacing="0">
							<tbody>
								<tr>
									<td rowspan="2" width="80">
										<img src="<?php echo $site_image; ?>product/small/<?php echo $Product['product_image'] ?>">
									</td>
									<td class="order_pro_title"><?php echo $Product['product_name'] ?></td>
									<td rowspan="2" width="50" align="right">
										<p style="color:#333;">￥<?php echo $Product['stock_price'] ?></p>
										<span><?php echo $Product['num'] ?>件</span>
										<?php if ( $Product['re_status'] == 1 ){ ?>
											<a href="javascript:void(0);" class="order_list_new_btn">审核中</a>
										<?php }elseif ( $objOrderInfo['order_status'] > 1 ){ ?>
											<a href="/orders.php?act=refund&odid=<?php echo $Product['user_order_detail_id']; ?>" class="order_list_new_btn">退款</a>
										<?php } ?>
									</td>
								</tr>
								<tr>
									<td style="vertical-align:bottom"><?php echo $Product['sku_desc']; ?></td>
								</tr>
							</tbody>
						</table>
					</a>




				<?php } ?>
			</li>
		</ul>
	</div>

	<div class="order_info_list">
		<h3>订单信息</h3>
		<ul>
			<li>
				<label>订单编号：</label>
				<div><?php echo $objOrderInfo['order_no']; ?></div>
			</li>
			<li>
				<label>收货方式：</label>
				<div>快递</div>
			</li>
			<li>
				<label>订单金额：</label>
				<div>
					<?php echo $objOrderInfo['all_price']; ?> (含运费<?php echo $objOrderInfo['espress_price']; ?>)
					<span style="color:#e61959;"><?php
						if ( $objOrderInfo['discount_price'] > 0 )
						{
							echo '( 已优惠' . $objOrderInfo['discount_price'] . ')';
						}
					?></span>
				</div>
			</li>

			<?php if ( $useOrderCoupon ){ ?>
				<li>
					<label>代金券号：</label>
					<div><?php echo $OrderCouponNo; ?></div>
				</li>
			<?php } ?>
			<li>
				<label>创建时间：</label>
				<div><?php echo $objOrderInfo['create_date']; ?></div>
			</li>
		</ul>
	</div>

	<?php include "footer_web.php";?>

</body>
</html>

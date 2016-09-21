<!doctype html>
<html lang="zh">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1, user-scalable=no" />
<title><?php echo $site_name;?></title>
<link href="/css/common.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="/js/jquery-1.11.0.min.js"></script>
<script src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>
<script type="text/javascript" src="/js/wxshare.js"></script>
<script>
	wxshare( <?php echo WXJSDEBUG;?>, '<?php echo WXJSAPPID;?>', <?php echo WXJSTIMESTAMP;?>, '<?php echo WXJSNONCESTR;?>', '<?php echo WXJSSIGNATURE;?>', '<?php echo WEBLOGO;?>', '<?php echo $SHARP_URL;?>', '<?php echo WEBTITLE;?>', '<?php echo WEBDESC;?>' )
</script>
<style>
	.user_edit *{font-size:14px;}
	.user_edit h3{font-weight:normal;border-bottom:1px solid #ddd;padding:10px;background:#fff;}
	.user_edit_item{background:none;padding-right:0;color:#666;}
</style>
</head>

<body>
	<div id="header">
	    <a href="javascript:history.go(-1);" class="header_back"></a>
	    <p class="header_title"><?php echo $title; ?></p>
	</div>

	<?php if ( $UserOrderRefundInfo->status >= 4 ){ ?>
		<div class="order_info_list refund_state">
			<?php if ( $UserOrderRefundInfo->status == 4 ){ ?>
				<h3 class="success">退款成功</h3>
			<?php } ?>

			<?php if ( $UserOrderRefundInfo->status == 5 ){ ?>
				<h3 class="fail">审核失败</h3>
			<?php } ?>

			<?php if ( $UserOrderRefundInfo->status == 6 ){ ?>
				<h3 class="fail">申请失败</h3>
			<?php } ?>

			<ul>
				<li>
					<label>退款金额</label>
					<div>
						<?php echo $UserOrderRefundInfo->stock_price - $UserOrderRefundInfo->coupon_price;  ?>元
					</div>
				</li>
				<li>
					<label>申请时间</label>
					<div><?php echo $UserOrderRefundInfo->create_date;  ?></div>
				</li>
			</ul>
		</div>
	<?php } ?>

		<div class="order_pro_list order_list_new">
			<ul>
				<li>
					<table border="0" cellpadding="0" cellspacing="0">
						<tbody><tr>
							<td width="80">
								<img src="<?php echo SITE_IMG .'product/small/' . $UserOrderRefundInfo->product_image; ?>">
							</td>
							<td class="order_pro_title"><?php echo $UserOrderRefundInfo->product_name;  ?></td>
							<td width="100" align="right">
								<p style="color:#333;">￥<?php echo $UserOrderRefundInfo->stock_price;  ?></p>
								<span style="color:#ccc;">×<?php echo $UserOrderRefundInfo->refund_num;  ?></span>
								<p style="color:#e61959; margin-top:10px;">优惠 ￥<?php echo sprintf( '%.1f',  $UserOrderRefundInfo->coupon_price);  ?></p>
							</td>
						</tr>
					</tbody></table>
				</li>
			</ul>
		</div>


	<div class="user_edit">
		<h3>协商详情</h3>
        <ul>
            <li>
                <label class="user_edit_label">退款类型</label>
                <div class="user_edit_item"><?php echo ($UserOrderRefundInfo->type == 1 ) ? "我要退款（无需退货）" : "我要退货"; ?></div>
            </li>
            <li>
                <label class="user_edit_label">退款金额</label>
                <div class="user_edit_item">￥<?php echo number_format($UserOrderRefundInfo->stock_price * $UserOrderRefundInfo->refund_num, 1 ); ?></div>
            </li>
            <li>
                <label class="user_edit_label">退款原因</label>
                <div class="user_edit_item"><?php echo $RefundType[$UserOrderRefundInfo->refund_Type]; ?></div>
            </li>
            <li>
                <label class="user_edit_label">退款说明</label>
                <div class="user_edit_item"><?php echo $UserOrderRefundInfo->refund_reason; ?></div>
            </li>
        </ul>
	</div>

	<?php if ( $UserOrderRefundInfo->status < 4 ){ ?>
		<div>
			<h3 class="pro_like"><div><i></i>猜你喜欢</div><hr/></h3>
			<div class="product_block_warp" style="margin-bottom:0;">
		        <ul>
	           		<?php foreach( $arrProductList as $Product ){ ?>
	           		<li>
			        	<div class="product_block_main">
	                    	<a class="p_img_warp" href="/product_detail?type=<?php echo $Product['type']; ?>&pid=<?php echo $Product['product_id'];?>">
	                            <div class="square_img"><img src="<?php echo $site_image?>/product/small/<?php echo $Product['image'];?>" alt="" /></div>
	                            <p><?php echo $Product['product_name']; ?></p>
	                        </a>

	                        <div class="p_desc_warp">
	                           <span>￥<?php echo number_format($Product['distribution_price'],1);?></span>
	                        </div>
	                    </div>
	          		</li>
	          		<?php } ?>
		        </ul>
			</div>
		</div>
	<?php } ?>

	<?php include "footer_web.php";?>
</body>
</html>

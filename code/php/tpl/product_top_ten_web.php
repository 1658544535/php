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
</head>

<body style="background:#fff;">
	<div id="header">
	    <a href="javascript:history.go(-1);" class="header_back"></a>
	    <p class="header_title">
			<?php echo $actTitle; ?>
	    </p>
	</div>

   	<div class="nr_warp">
		<?php if( $productList == null ){ ?>
			<div class="order_empty" >
				<dl>
					<dd><img src="/images/order/orderlist_icon.png" width="100" /></dd>
					<dd>暂无商品</dd>
					<dd>
						<a href="/product?act=top">
							<img src="/images/order/go_icon.png" width="130" />
						</a>
					</dd>
				</dl>
			</div>
		<?php }else{ ?>

			<div class="product_block_warp">
				<div id="initRender">
		        	<dl>
						<?php foreach($productList as $key=>$product){ ?>
							<dd>
								<a href="/product_detail?type=3&pid=<?php echo $product->id;?>" pitem="<?php echo $product->id;?>" onclick="preShow(this)" curpage="1">
									<div class="p_img_warp">
										<img class="lazyload" data-original="<?php echo $site_image?>/product/<?php echo $product->image;?>" />
									</div>

									<div class="p_desc_warp">
										<p class="title">
											<?php if ( $key < 10 ){ ?>
												<img src="/images/tn<?php echo $key+1; ?>.png" alt="" width='20%' class="tip" />
											<?php } ?>
											<?php echo $product->product_name; ?>
										</p>

										<p class="price">
											<span class="btn">去购买</span>
											￥<span class="now"><?php echo number_format($product->active_price,1);?></span></br>
											<span class="old">￥<?php echo number_format($product->sell_price,1);?></span>
										</p>
									</div>
								</a>
							</dd>
						<?php } ?>
						<div id="page-bot"></div>
						<div class='clear'></div>
		        	</dl>
		        </div>
		    </div>
		<?php } ?>
		<div id="progressIndicator" style="width:320px;text-align: center; display: none;">
			<img width="85" height="85" src="images/ajax-loader-85.gif" alt="">
			<span id="scrollStats" style="font-size: 70%; width: 80px; text-align: center; position: absolute; bottom: 25px; left: 2px;"></span>
		</div>
	</div>

<?php include "footer_web.php"; ?>

</body>
</html>
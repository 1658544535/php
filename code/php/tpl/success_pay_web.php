<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="zh-CN">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=100%; initial-scale=1; maximum-scale=1; minimum-scale=1; user-scalable=no;" />
<meta content="telephone=no" name="format-detection" />
<title><?php echo $site_name;?></title>
<link href="/css/index3.css" rel="stylesheet" type="text/css" />
<link href="/css/common.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="js/jquery-1.8.3.min.js"></script>
<script src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>
<script type="text/javascript" src="/js/wxshare.js"></script>
<script>
	wxshare( <?php echo WXJSDEBUG;?>, '<?php echo WXJSAPPID;?>', <?php echo WXJSTIMESTAMP;?>, '<?php echo WXJSNONCESTR;?>', '<?php echo WXJSSIGNATURE;?>', '<?php echo WEBLOGO;?>', '<?php echo $SHARP_URL;?>', '<?php echo WEBTITLE;?>', '<?php echo WEBDESC;?>' )
</script>

<style>
	.order-wrapper{ padding:20px 0; }
	.order-wrapper #title{ text-align:center; font-size:16px; padding:20px 0 50px; }
	.order-wrapper .nav_warp { height:30px; line-height:30px; border-top:1px dashed #e3e3e3;  }
	.order-wrapper .nav_warp dd{ width:33%; float:left; text-align:center; color:#666; }
	.order-wrapper .nav_warp dd a{ color:#666; }
</style>

</head>

<body>
	<div id="header">
		<!--<a href="/cart?return_url=/;" class="header_back"></a>-->
		<p class="header_title">支付结果</p>
	</div>

	<div class="nr_warp">
		<div class="order-payState success">
			<div class="state">
				<i class="img"></i>
				<span>支付成功</span>
			</div>
			<a class="btn" href="/orders?sid=2&return_url=user">查看订单</a>
		</div>

		<div class="order-like">
			<h3 class="title">猜你喜欢</h3>
			<div class="product_block_warp">
				<div id="initRender">
		        	<ul>
						<?php foreach ($objhistory as $his){?>
						<li>
							<div class="product_block_main">
								<a class="p_img_warp" href="product_detail?type=3&pid=<?php echo $his->business_id;?>">
									<div class="square_img"><img class="lazyload" src="<?php echo $site_image;?>product/<?php echo $his->image;?>" /></div>
									<p><?php echo $his->pname;?></p>
								</a>
		                        <div class="p_desc_warp">
		                           <span>￥<?php echo $his->active_price;?></span>
		                        </div>
							</div>
						</li>
					<?php }?>
					</ul>
				</div>
		    </div>
		</div>
	</div>
	<?php include "footer_web.php"; ?>

</body>
</html>

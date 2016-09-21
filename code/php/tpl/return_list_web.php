<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="zh-CN">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta charset="utf-8" name="viewport"
	content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" />
<meta content="telephone=no" name="format-detection" />
<title><?php echo $site_name;?></title>
<link href="/css/common.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="js/jquery-1.8.3.min.js"></script>
<script type="text/javascript" src="js/jquery.cycle.all.js"></script>
<script src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>
<script type="text/javascript" src="/js/wxshare.js"></script>
<script>
	wxshare( <?php echo WXJSDEBUG;?>, '<?php echo WXJSAPPID;?>', <?php echo WXJSTIMESTAMP;?>, '<?php echo WXJSNONCESTR;?>', '<?php echo WXJSSIGNATURE;?>', '<?php echo WEBLOGO;?>', '<?php echo $SHARP_URL;?>', '<?php echo WEBTITLE;?>', '<?php echo WEBDESC;?>' )
</script>
</head>

<body>
	<div id="header">
		<dl id="title_warp">
			<dd>
				<a href="javascript:window.history.back(-1);">
					<img src="/images/index/icon-back.png" />
				</a>
			</dd>
			<dd class="page-header-title">退货 / 退款</dd>
			<dd><!--<img src="/images/index/icon-back.png" />--></dd>
		</dl>
	</div>

<div class="nr_warp">
	<?php if ( count($returnList) == 0 ){ ?>
		<div class="order_empty" >
			<dl>
				<dd><img src="/images/order/orderlist_icon.png" width="100" /></dd>
				<dd>暂无售后订单</dd>
			</dl>
		</div>
	<?php }else{ ?>
		<?php

		foreach($returnList as $return)
		{
			$productImage 	= $product->get_results_productid($db,$return->product_id);
			$shop_info 		= $user_shop->detail_id($db,$return->shop_id);
		?>
		<div class="order_list">
			<div class='product_line_warp'>
				<a href="/shop_detail?id=<?php  echo $shop_info->id;?>">
					<dt>
						<img src="<?php echo $site_image?>shop/<?php echo $shop_info->images;?>" height='30' style="margin:-5px 10px 0 0; float:left;" />
						<strong><?php echo  $shop_info->name; ?></strong>
					</dt>
				</a>

				<a href="/returnapply?id=<?php echo $return->detail_id; ?>" >

						<dd>
							<div class="p_img_warp">
								<img src="<?php echo $site_image?>/product/small/<?php echo $productImage->image;?>" alt="" width="80" />
							</div>
							<div class="p_desc_warp">
								<p>
									<?php
										$name = $return->product_name;
										mb_internal_encoding('utf8');//以utf8编码的页面为例
										//如果内容多余16字
										echo (mb_strlen($name)>30) ? mb_substr($name,0,30).'...' : $name;
									?>
								</p>
								<p>
									退货数量： <?php echo $return->refund_num;?>
								</p>
							</div>
							<div class="clear"></div>
						</dd>

						<div class="order_but_warp">
							<?php if( $return->status == 1 ){ ?>
									<span class="status_desc">审核中</span>
									<!--<input style="margin:5px;"  name="" type="submit" value="正在审核中" class="order-list-waitButtons" />-->
				 			<?php }else if( $return->status == 2 ){ ?>
				 					<a href="/returnapply?id=<?php echo $return->detail_id; ?>" class="status_desc">审核通过，请退货</a>
				 					<!-- <input style="margin:5px;"  name="" type="submit" value="请退货" class="order-list-waitButtons" /> -->
				 	 		<?php }else if( $return->status == 3 ){ ?>
				 	 				<span class="status_desc">退货中</span>
				 	 				<!--<input style="margin:5px;"  name="" type="submit" value="退货中" class="order-list-waitButtons" />-->
				 	 		<?php }else if( $return->status == 4 ){ ?>
				 	 				<span class="status_desc">退货成功</span>
				 	 	 	<?php }else if( $return->status == 5 ){ ?>
				 	 	 			<span class="status_desc">退货失败</span>
				 	 	 	<?php }else { ?>
				 	 	 			<span class="status_desc">审核不成功</span>
			 	   			<?php } ?>
						</div>
				</a>
			</div>

		<?php } ?>
	<?php } ?>
</div>
</div>
<?php include "footer_web.php"; ?>
</br>
</br>
</br>
<?php include "footer_menu_web_tmp.php"; ?>
</body>
</html>

<!doctype html>
<html lang="zh">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1, user-scalable=no" />
<title><?php echo $site_name;?></title>
<link href="/css/common.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="/js/jquery-1.11.0.min.js"></script>
<script type="text/javascript" src="js/jquery.cycle.all.js"></script>
<script src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>
<script type="text/javascript" src="/js/wxshare.js"></script>
<script>
	wxshare( <?php echo WXJSDEBUG;?>, '<?php echo WXJSAPPID;?>', <?php echo WXJSTIMESTAMP;?>, '<?php echo WXJSNONCESTR;?>', '<?php echo WXJSSIGNATURE;?>', '<?php echo WEBLOGO;?>', '<?php echo $SHARP_URL;?>', '<?php echo WEBTITLE;?>', '<?php echo WEBDESC;?>' )

	function history_refush(){
		if(confirm("确定要清空记录吗?"))
		{
			$.ajax({
				url:'/user_info?act=history_flush',
				type:'POST',
				dataType: 'string',
				error: function(){
	     			alert('请求超时，请重新添加');
	    		},
	    		success: function(result){
	    			location.href = '/user_info?act=history&return_url=/user';
	    		}
			});
		}
		return false;
	}
</script>

</head>

<body>
<div id="header">
    <a href="user.php" class="header_back"></a>
    <p class="header_title">我的足迹</p>
</div>

	<div id="nr_warp">

		<?php if( $arrHistory == null){ ?>
			<div class="order_empty" >
				<dl>
					<dd><img src="/images/order/orderlist_icon.png" width="100" /></dd>
					<dd>您一周内暂无浏览记录</dd>
				</dl>
			</div>
		<?php }else{ ?>
   			<div class="product_line_warp" >
				<?php foreach( $arrHistory as $date=>$history_group ){ ?>
					<dl>
						<dt style=""><?php echo $date; ?> （共查看 <?php echo count($history_group) ?> 件宝贝） </dt>
						<?php

						foreach( $history_group as $history )
						{
							if ( isset($history->info) ){
								$obj_product = $history->info;
						?>
							<a href="/product_detail?&type=<?php echo $obj_product->activity_type; ?>&pid=<?php echo $history->business_id; ?>&aid=<?php echo $obj_product->activity_id ;?>">
					            <dd>
									<div class="p_img_warp">
										<div class="<?php echo ( $obj_product->enable == 0) ?  'undercarriage' : '' ?>"></div>
										<img src="<?php echo $site_image ?>/product/small/<?php echo $obj_product->image;?>" alt=""/>
									</div>
									<div class="p_desc_warp">
										<p><?php echo $obj_product->product_name;?></p>
										<p>
											<?php if( $obj_product->status == 0){ ?>
			                    				商品已下架
			                    			<?php }else{ ?>
			                    				<?php echo '￥' . sprintf('%.1f',$obj_product->active_price); ?>
			                    			<?php } ?>
			                    		</p>
									</div>
									<div class="clear"></div>
					            </dd>
							</a>
						<?php }} ?>
					</dl>
				<?php } ?>
	    	</div>
		<?php } ?>
	 </div>

	<?php include "footer_web.php"; ?>


</body>
</html>

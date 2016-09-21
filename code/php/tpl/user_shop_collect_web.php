<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="zh-CN">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta charset="utf-8" name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" />
<title><?php echo $site_name;?></title>
<link href="css/index4.css" rel="stylesheet" type="text/css" />
<link href="/css/common.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="js/jquery-1.4.2.min.js"></script>
<script type="text/javascript" src="js/jquery.cycle.all.js"></script>
<script src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>
<script type="text/javascript" src="/js/wxshare.js"></script>
<style type="text/css">
	.notsell .p_img_warp img{-moz-opacity:0.2;opacity:0.2;}
	.notsell .p_desc_warp{color:#ccc}
</style>
<script>
	wxshare( <?php echo WXJSDEBUG;?>, '<?php echo WXJSAPPID;?>', <?php echo WXJSTIMESTAMP;?>, '<?php echo WXJSNONCESTR;?>', '<?php echo WXJSSIGNATURE;?>', '<?php echo WEBLOGO;?>', '<?php echo $SHARP_URL;?>', '<?php echo WEBTITLE;?>', '<?php echo WEBDESC;?>' )
</script>
<script type="text/javascript">
function buy_now(product_id){
	$.ajax({
		url:'cart?userid=<?php echo $userid;?>&product_id='+product_id,
		type:'POST',
		dataType: 'string',
		error: function(){
     		alert('请求超时，请重新添加');
    	},
    	success: function(result){
			location.href = 'cart.php';
    	}
	});
}

function replace(favorid){
	if(confirm("确定要删除该品牌吗?"))
	{
		$.ajax({
			url:'user_shop_collect?act=del&id='+favorid,
			type:'POST',
			dataType: 'string',
			error: function(){
     			alert('请求超时，请重新添加');
    		},
    		success: function(result){
    			location.href = 'user_shop_collect?return_url=<?php echo $return_url; ?>';
    		}
		});
	}
	return false;
}
</script>

</head>

<body>

	<div id="header">
		<dl id="title_warp">
			<dd>
				<a href="<?php echo $return_url; ?>" class="back">
					<img src="/images/index/icon-back.png" />
				</a>
			</dd>
			<dd class="page-header-title">品牌收藏</dd>
			<dd><!--<img src="/images/index/icon-back.png" />--></dd>
		</dl>
	</div>


	<div class="nr_warp">
		<dl class="favs_tabs">
			<a href="/favorites?return_url=<?php echo $return_url; ?>">
				<dd class="large">商品收藏</dd>
			</a>
			<dd class="large" id="active_tab">品牌收藏</dd>
			<div class="clear"></div>
		</dl>



		<?php if( $favoriteList!= null ){ ?>
		<div class="product_line_warp">
				<?php
			foreach($favoriteList as $fav)
			{
				$obj_product = $ub->detail_id($db,$fav->shop_id);
				$main_category=$db->get_var("select name from sys_dict where type ='main_category'and value='".$obj_product->main_category."' ");
		?>
			<dl>
				<dd>
					<a href="<?php if($fav->status){ ?>shop_detail?id=<?php echo $obj_product->id;?><?php }else{ ?>javascript:;<?php } ?>" class="<?php if(!$fav->status){ ?>notsell<?php } ?>">
						<div class="p_img_warp">
							<img src="<?php echo $site_image?>shop/<?php echo $obj_product->images;?>" alt="" />
						</div>

						<div class="p_desc_warp">
							<p><?php if(!$fav->status){ ?><span style="color:#f00">[已下架]</span><?php } ?><?php echo mb_substr($obj_product->name , 0 , 20 ,'utf-8');?></p>
						</div>
					</a>
					<a onclick="replace(<?php echo $obj_product->id;?>);">
						<div class="p_img_warp" style="width:40px; margin-top:10px; text-align:right;" >
							<img src="images/cart/del.png" alt="" style="border:none; width:22px; height:22px;" />
						</div>
					</a>

				</dd>
			</dl>

			<div class="clear"></div>
			<?php } ?>
		</div>
		<?php }else { ?>
			<div class="order_empty" >
				<dl>
					<dd><img src="/images/order/orderlist_icon.png" width="100" /></dd>
					<dd>您暂无收藏的品牌！</dd>
					<!--
					<dd>
						<a href="/product?act=top">
							<img src="/images/order/go_icon.png" width="130" />
						</a>
					</dd>
					-->
				</dl>
			</div>
		<?php }?>
	</div>
</br>
</br>
</br>
<?php include "footer_web.php"; ?>
</br>
</br>
</br>
<?php include "footer_menu_web_tmp.php"; ?>
</body>
</html>

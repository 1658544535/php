<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="zh-CN">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta charset="utf-8" name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" />
<title>淘竹马</title>
<link href="css/index4.css" rel="stylesheet" type="text/css" />
<link href="/css/common.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="js/jquery-1.4.2.min.js"></script>
<script src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>
<script type="text/javascript" src="/js/wxshare.js"></script>
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
	if(confirm("确定要移除该分销产品吗?"))
	{
		$.ajax({
			url:'distribution?act=del&id[]='+favorid,
			type:'POST',
			dataType: 'string',
			error: function(){
     			alert('请求超时，请重新添加');
    		},
    		success: function(result){
    			location.href = 'distribution?return_url=<?php echo $_GET['return_url'] ?>';
    		}
		});
	}
	return false;
}
</script>

</head>

<body>
<div class="list-nav">
	<a href="<?php echo $_GET['return_url'] ?>" class="back"></a>
    <div class="member-nav-M">分销产品库</div>
</div>

<div class="index-wrapper">

	<?php
		foreach($favoriteList as $favs){
	?>
			<div class="order_list" style="margin-bottom:20px; background:#fff;" >
				<a href="/shop_detail?id=<?php  echo $favs['shop_id'];?>">
					<div class="order_list_title">
						<img src="/images/shop.png" height='25' style="margin:8px 10px 0 0; float:left;" />
						<span class="shop_name"><strong style="font-size:14px;"><?php echo  $favs['shop_name']; ?></strong></span>
						<!--<span class="icon-angle-right"></span>-->
						<span style="float:right; margin:13px 14px 0px 0px;"><img src="images/forward-32.png" width="15" height:"15"/></span>
					</div>
				</a>

				<?php
					foreach( $favs['info'] as $fav ){
						$obj_product = $product->details($db,$fav->product_id);
				?>
					<?php if( $obj_product->status == 1){ ?>
						<a href="product_detail?product_id=<?php echo $obj_product->id;?>">
					<?php } ?>
						<div class="order_list_list <?php echo ($obj_product->status == 0) ? 'undercarriage' : '' ?>" style="padding:5px 0;">
							<div class="product_img">
								<img src="<?php echo $site_image?>product/small/<?php echo $obj_product->image;?>" alt="" width="85" height="85" class="shoppingCart-table-Pic02-border"/>
							</div>
							<div class="product_name">
								<p>商品名称：
									<?php
										$v = $obj_product->product_name;  //以$v代表‘长描述’
										mb_internal_encoding('utf8');//以utf8编码的页面为例
										echo (mb_strlen($v)>16) ? mb_substr($v,0,16).'...' : $v;
									?>

								</p>
								<p style="font-size:12px; color:#df434e; margin-top:10px;" >分销价：￥<?php echo $obj_product->distribution_price;?>元 </p>
							</div>
						</div>

						<div class="order_buttom" style="text-align:right; margin-top:10px; ">
							<?php if( $obj_product->status == 1){ ?>
								<a href="product_detail?product_id=<?php echo $obj_product->id;?>" class="red_btn">商品详情</a>
							<?php }else{ ?>
								<span class="tip_btn">商品已下架</span>
							<?php } ?>
							<a href="#" class="write_btn"  onclick="replace(<?php echo $fav->id;?>);" >移出分销库</a>
						</div>
					<?php if( $obj_product->status == 1){ ?>
						</a>
					<?php } ?>
				<?php } ?>
			</div>
	<?php } ?>
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

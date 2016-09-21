<!doctype html>
<html lang="zh">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1, user-scalable=no" />
<meta content="telephone=no" name="format-detection" />
<title>淘竹马</title>
<link href="/css/common.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="/js/jquery-1.11.0.min.js"></script>
<script src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>
<script type="text/javascript" src="/js/wxshare.js"></script>
<script>
	imgUrl 	= '<?php echo $site_image?>shop/<?php echo $shop->images;?>';
	link 	= "<?php echo $SHARP_URL ?>";
	title 	= "淘竹马店铺推荐：<?php echo $shop->name;?>";

	wxshare( <?php echo WXJSDEBUG;?>, '<?php echo WXJSAPPID;?>', <?php echo WXJSTIMESTAMP;?>, '<?php echo WXJSNONCESTR;?>', '<?php echo WXJSSIGNATURE;?>', imgUrl, link, title, '<?php echo WEBDESC;?>' )
</script>

<script type="text/javascript">
	function distribution(sid){
		$("#addFavor").addClass("load");
		var pid = $("#standard").val();
		$.ajax({
		url:'user_shop_collect.php?act=add&userid=<?php echo $userid;?>&sid='+sid,
			type:'POST',
			error: function(){
	     		fadeInTips('请求超时，请重新添加');
	    	},
	    	success: function(result){
	    		var a = result.indexOf('<!DOCTYPE');
	    		if(a > 0){
	    			alert(result.substr(0,a));
	    		}else{
	    			$("#addFavor").addClass("active").removeClass("load");
	    			fadeInTips('成功关注！');
	    		}
	    	}
		});
	}
	function fadeInTips(txt){
		var ahtml = '<div class="fadeInTips">' + txt + '</div>';
		if($(".fadeInTips").length<=0){
			$("body").append(ahtml);
		}else{
			$(".fadeInTips").html(txt);
		}
		setTimeout(function(){
			$(".fadeInTips").fadeOut(800,function(){
				$(".fadeInTips").remove();
			});
		},500);
	}
</script>
</head>

<body>
	<div id="header">
		<a href="javascript:history.go(-1);" class="header_back"></a>
		<p class="header_title"><?php echo $shop->name;?></p>

	 	<?php if( $user == null){ 					// 如果不是下架的商家  ?>
	 		<a id="addFavor" href="user_binding?dir=<?php echo $_SERVER['REQUEST_URI']; ?>" class="header_collections" title="关注"></a>
        <?php }else if( $shop->status == 1){ 		// 如果不是下架的商家 ?>
			<?php if ( $is_collect ){  				// 是否收藏 ?>
				<a id="addFavor" href="javascript:;" title="已关注" class="header_collections active"></a>
			<?php }else{ ?>
				<a id="addFavor" href="javascript:distribution(<?php echo $shop->id;?>);" class="header_collections" title="关注"></a>
			<?php } ?>
        <?php } ?>
	</div>

	<div class="nr_warp">
		<div class="pro_list_sort pro_list_sort_3">
			<a href="#" class="down">人气<i></i></a>
			<a href="#" class="">价格<i></i></a>
			<a href="#" class="up">销量<i></i></a>
		</div>


		<?php if ( $shop->top_image != "" ){ ?>
			<div class="shop_img_warp">
				<img src="<?php echo $site_image .'shop/'. $shop->top_image; ?>" />
			</div>
		<?php } ?>

		<div class="shop_desc_warp">
			<p><?php echo $shop->content;?></p>
		</div>

		<?php if($shop->status == 0){ ?>
			<div style="padding:30px 0; text-align:center; color:#f00; font-size:14px;background:#fff;">此品牌已下架</div>
		<?php }else{ ?>
			<?php if ( is_array($similar_products)  ){ ?>
				<div class="product_block_warp">
			        <ul>
			        	<?php foreach($similar_products as $product){ ?>
		                   	<li>
		                        <div class="product_block_main">
		                        	<a class="p_img_warp" href="product_detail?product_id=<?php echo $product->id;?>">
			                            <img src="<?php echo $site_image?>/product/small/<?php echo $product->image;?>" alt="" />
			                            <p><?php echo $product->product_name; ?></p>
			                        </a>

			                        <div class="p_desc_warp">
			                           <span>￥<?php echo number_format($product->distribution_price,1);?></span>
			                           <a href="product_detail?product_id=<?php echo $product->id;?>">立即购买</a>
			                        </div>
		                        </div>
		                  	</li>
		                  <?php } ?>
			        </ul>
				</div>
			<?php } ?>
		<?php } ?>
	</div>

<?php include "footer_web.php"; ?>
</body>
</html>

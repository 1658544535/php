<!doctype html>
<html lang="zh">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1, user-scalable=no" />
<meta content="telephone=no" name="format-detection" />
<title>淘竹马</title>
<link href="/css/common.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="/js/jquery-1.11.0.min.js"></script>
<script type="text/javascript" src="/js/jweixin-1.0.0.js"></script>
<script type="text/javascript" src="/js/wxshare.js"></script>
<script>
	imgUrl 	= '<?php echo $site_image?>shop/<?php echo $shop->images;?>';
	link 	= "<?php echo $SHARP_URL ?>";
	title 	= "淘竹马专场推荐：<?php echo $objSpecialInfo->title; ?>";

	wxshare( <?php echo WXJSDEBUG;?>, '<?php echo WXJSAPPID;?>', <?php echo WXJSTIMESTAMP;?>, '<?php echo WXJSNONCESTR;?>', '<?php echo WXJSSIGNATURE;?>', imgUrl, link, title, '<?php echo WEBDESC;?>' )
</script>

<script type="text/javascript">
	function Favor(sid){
		$("#addFavor").addClass("load");
		var url = "special_detail.php?act=collect&aid="+sid;
		$.get(url, function(result){
			fadeInTips(result.msg);
			$("#addFavor").removeClass("load");
			if ( result.code == 2 )
			{
				$("#addFavor").removeClass("active");
			}
			else
			{
				$("#addFavor").addClass("active");
			}

	    	$("#addFavor").attr("href","javascript:Favor("+sid+");");
		}, "json");
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
		<a href="/index" class="header_back"></a>
		<p class="header_title"><?php echo $objSpecialInfo->title;?></p>

	 	<?php if( $user == null){ ?>
	 		<a id="addFavor" href="user_binding?dir=<?php echo $_SERVER['REQUEST_URI']; ?>" class="header_collections" title="关注"></a>
        <?php }else{ ?>
			<a id="addFavor" href="javascript:Favor(<?php echo $objSpecialInfo->activity_id;?>);" class="header_collections <?php echo $bUserCollect ? 'active' : ''; ?> " title="关注"></a>
        <?php } ?>
	</div>

	<div class="nr_warp">
		<div class="pro_list_sort">
			<a href="<?php echo $url; ?>">综合</a>
			<a id="col_hits" href="<?php echo $url . $ColUrl['hits']; ?>">人气<i></i></a>
			<a id="col_price" href="<?php echo $url . $ColUrl['price']; ?>">价格<i></i></a>
			<a id="col_num" href="<?php echo $url . $ColUrl['num']; ?>">销量<i></i></a>
		</div>
		<script>
			$(function(){
				//排序样式
				function getUrlParam(name) {
		            var reg = new RegExp("(^|&)" + name + "=([^&]*)(&|$)"); //构造一个含有目标参数的正则表达式对象
		            var r = window.location.search.substr(1).match(reg);  //匹配目标参数
		            if (r != null) return unescape(r[2]); return null; //返回参数值
		        }
		        (function(){
		        	var px_col = getUrlParam('col'),
		        		px_orderBy = getUrlParam('order_by');
		        	if(typeof(px_col) == 'string'){
		        		var orderBy_class = '';
		        		px_orderBy == 'DESC' ? orderBy_class = 'up' : orderBy_class = 'down';
		        		$("#col_"+px_col).addClass(orderBy_class);
		        	}else{
		        		$(".pro_list_sort a").eq(0).addClass("on");
		        	}
		        })();
			})
		</script>


		<?php if ( $objSpecialInfo->banner != "" ){ ?>
			<div class="shop_img_warp">
				<img src="<?php echo $site_image .'specialShow/'. $objSpecialInfo->banner; ?>" />
				<div class="shop_img_discount">

					<?php if ( $objSpecialInfo->discount_type > 0 ){ ?>
						<p class="scene_discount">
							<?php if( $objSpecialInfo->discount_type == 1 ){ ?>
									<i class="green">减</i>
							<?php }elseif( $objSpecialInfo->discount_type == 2 ){ ?>
									<i class="red">折</i>
							<?php } ?>
							<span><?php echo $objSpecialInfo->discount_tip; ?></span>
						</p>
					<?php } ?>

					<div class="seckillend" id="seckillend">
						<span id="seckillendtime"><span class="timenum">00</span>:<span class="timenum">00</span>:<span class="timenum">00</span></span>
					</div>

				</div>
			</div>
		<?php } ?>

		<div class="shop_desc_warp">
			<p><?php echo $objSpecialInfo->brand_desc;?></p>
		</div>

		<?php if ( is_array($objSpecialProductList)  ){ ?>
			<div class="product_block_warp">
		        <ul>
		        	<?php foreach($objSpecialProductList as $product){ ?>
	                   	<li>
	                        <div class="product_block_main">
	                        	<a class="p_img_warp" href="product_detail?type=3&pid=<?php echo $product->id;?>">
		                            <div class="square_img"><img src="<?php echo $site_image?>/product/small/<?php echo $product->image;?>" alt="" /></div>
		                            <p><?php echo $product->product_name; ?></p>
		                        </a>

		                        <div class="p_desc_warp">
		                           <span>￥<?php echo number_format($product->active_price,1);?></span>
		                           <a href="product_detail?pid=<?php echo $product->id;?>">立即购买</a>
		                        </div>
	                        </div>
	                  	</li>
	                  <?php } ?>
		        </ul>
			</div>
		<?php } ?>
	</div>

	<?php include "footer_web.php"; ?>

	<script language="javascript">
		$(function(){
			<?php if(isset($seckillTimeDiff) && $seckillTimeDiff){ ?>
			downcount(<?php echo $seckillTimeDiff;?>);
			<?php } ?>
		});


		function downcount(_diff){
			if(_diff > 0){
				showTime(_diff);
				setTimeout(function(){downcount(--_diff);}, 1000);
			}else if(_diff == 0){
				window.location.reload();
			}
		}

		function showTime(_diff){
			var _hour = parseInt(_diff / 3600);
			_diff = _diff % 3600;
			var _minute = parseInt(_diff / 60);
			var _second = _diff % 60;
			_hour = (_hour < 10) ? "0"+_hour : _hour;
			_minute = (_minute < 10) ? "0"+_minute : _minute;
			_second = (_second < 10) ? "0"+_second : _second;
			$("#seckillendtime").html('<span class="timenum"><?php echo $dateTip; ?></span> <span class="timenum">'+_hour+'</span>:<span class="timenum">'+_minute+'</span>:<span class="timenum">'+_second+'</span>');
			$("#seckillend").show();
		}
	</script>
</body>
</html>

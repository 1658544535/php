<!doctype html>
<html lang="zh">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1, user-scalable=no" />
<title><?php echo $site_name;?></title>
<link href="/css/common.css" rel="stylesheet" type="text/css" />
<link href="/js/swiper/swiper.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="/js/jquery-1.11.0.min.js"></script>
<script src="/js/swiper/swiper.min.js"></script>
<script src="/js/jquery.touchslider.js"></script>
<script src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>
<script type="text/javascript" src="/js/wxshare.js"></script>
<style>
	.product_block_warp .p_desc_warp{margin:10px 5px;padding:0;text-align:center;}
</style>

<script type="text/javascript">
	imgUrl 	= '<?php echo $site_image?>product/small/<?php echo $objProductInfo->image;?>';
	link 	= window.location.href;// "<?php echo $SHARP_URL ?>";
	title 	= "<?php echo $objProductInfo->product_name;?>";

	wxshare( <?php echo WXJSDEBUG;?>, '<?php echo WXJSAPPID;?>', <?php echo WXJSTIMESTAMP;?>, '<?php echo WXJSNONCESTR;?>', '<?php echo WXJSSIGNATURE;?>', imgUrl, link, title, '<?php echo WEBDESC;?>' )

	function sku_confirm(product_id){
		var info = {
            id  		: product_id,
            type		: <?php echo $atype;?>,
			sku_id		: $("#sku_id").val()
        };

		$.ajax({
			url:'cart.php?act=add',
			data:info,
			type:'POST',
			dataType: 'json',
			error: function(){
	     		alert('请求超时，请重新添加');
	    	},
	    	success: function(result){
	    		if( result.code < 1){
	    			fadeInTips( result.msg );
	    		}
	    		else{					//加入购物车
	    			skuClose();
    				setTimeout(function(){
    					fadeInTips(result.msg);
    				},300);
	    			// $(".addCart_success").fadeIn();
	    			// setTimeout(function(){
	    			// 	$(".addCart_success").fadeOut();
	    			// },10000);
	    			gCartNum();
		    	}
	    	}
	    });
	}

	function Favor(productId){
		$("#addFavor").addClass("load");
		var url = "product_detail.php?act=collect&pid="+productId;
		$.get(url, function(result){
			fadeInTips(result.msg);
			$("#addFavor").removeClass("load");
			if ( result.code == 1)
			{
				$("#addFavor").addClass("active");
			}
			else
			{
				$("#addFavor").removeClass("active");
			}

	    	$("#addFavor").attr("href","javascript:Favor("+productId+");");
		}, "json");
	}

	function updatePrice(){
		var skuColorId = $("#sku_color_id").val();
		var skuFormatId = $("#sku_farmat_id").val();
		var url = "/product_detail.php";
		var data = {"act":"price","pid":<?php echo $objProductInfo->id;?>,"scid":skuColorId,"sfid":skuFormatId};
		$.get(url, data, function(r){
			if(r.code > 0){
				$("#buy_price,#buy_price2").text(r.data.price);
				$("#sku_id").val(r.data.skuid);
			}
		}, "json");

		var chooseTxt = '';
		if($(".sku_box a#choose").length<=0){
			chooseTxt = '请选择颜色和规格';
		}else{
			$(".sku_box a#choose").each(function(index, el) {
				var txt = $(el).html();
				txt = '“' + txt + '”';
				chooseTxt += txt;
			});
			chooseTxt = "已选择" + chooseTxt;
		}
		
		$("#chooseTxt, #chooseTxt2").html(chooseTxt);
	}

	function gCartNum(){
		$.get("/tool.php", {"t":"cartnum"}, function(r){
			if(r.n > 0) {
				if (parseInt(r.n) >= 100) r.n = "...";
				$("#cart-tip").text(r.n).show();
			}
		}, "json");
	}

	function skuOpen(state){
		$(".popup_sku").show();
		setTimeout(function(){
			$(".popup_sku_main").addClass("active");
		},30);
	}

	function skuClose(){
		$(".popup_sku_main").removeClass("active");
		setTimeout(function(){
			$(".popup_sku").hide();
		},300);
	}

	function showDIv(obj){
		document.getElementById(obj).style.display = "block";
	}
	function hideDiv(obj){
		document.getElementById(obj).style.display = "none";
	}

	$(function(){
		gCartNum();													// 获取购物车的数量
		$(".touchslider-demo").touchSlider({mouseTouch: true});		// 轮播图

		if(!$('.color_sku')[0] && !$('.format_sku')[0]){
			$("#buy_price2").text("<?php echo sprintf('%.1f',$objProductInfo->active_price);?>");
		}

		$('.color_sku').on('click','.sku_color',function(){
			var val = $(this).attr('data-value');
			var now_val = $('#sku_color_id').val();
			$('.sku_color').attr('id','');

			if ( now_val != val )
			{
				$(this).attr('id','choose');
				$('#sku_color_id').val(val);
			}
			else
			{
				$('#sku_color_id').val('');
				$('#sku_farmat_id').val('');
				$('#sku_id').val('');
				val = 0;
			}
			updatePrice();
			var html = '';

			$.ajax({
				url: '/product_detail.php?pid=<?php echo $objProductInfo->id;?>&sid='+ val +'&act=sku_format',
				dataType:'json',
				success: function(result){

					if ( result.code < 1 )
					{
						alert(result.msg);
					}
					else
					{
						html = "<dt>产品规格：</dt>";
						$.each(result.data,function(k,v){
							html += "<dd>";
							if ( v.has == 1 )
							{
								if ( $('#sku_farmat_id').val() == v.Id )
								{
									html += 	"<a class='sku_format' data-value='"+ v.Id +"' id='choose' >" + v.value + "</a>";
								}
								else
								{
									html += 	"<a class='sku_format' data-value='"+ v.Id +"' >" + v.value + "</a>";
								}
							}
							else
							{
								html += 	"<span>" + v.value + "</span>";
							}
							html += "</dd>";
						})

						$('.format_sku').html(html);
					}
				}
			})
		})

		$('.format_sku').on('click','.sku_format',function(){
			var val = $(this).attr('data-value');
			$('.sku_format').attr('id','');
			var now_val = $('#sku_farmat_id').val();

			if ( now_val != val )
			{
				$(this).attr('id','choose');
				$('#sku_farmat_id').val(val);
			}
			else
			{
				$('#sku_color_id').val('');
				$('#sku_farmat_id').val('');
				$('#sku_id').val('');
				val = 0;
			}
			updatePrice();
			var html = '';

			$.ajax({
				url: '/product_detail.php?pid=<?php echo $objProductInfo->id;?>&sid='+ val +'&act=sku_color&acid=<?php echo $activeId;?>',
				dataType:'json',
				success: function(result){
					if ( result.code < 1 )
					{
						alert(result.msg);
					}
					else
					{
						html = "<dt>产品颜色：</dt>";
						$.each(result.data,function(k,v){
							html += "<dd>";
							if ( v.has == 1 )
							{
								if ( $('#sku_color_id').val() == v.Id )
								{
									html += 	"<a class='sku_color' data-value='"+ v.Id +"' id='choose' >" + v.value + "</a>";
								}
								else
								{
									html += 	"<a class='sku_color' data-value='"+ v.Id +"' >" + v.value + "</a>";
								}
							}
							else
							{
								html += 	"<span>" + v.value + "</span>";
							}
							html += "</dd>";
						})

						$('.color_sku').html(html);
					}
				}
			})
		})


		// if($(".sku_color").length>0){
		// 	$(".sku_color").eq(0).trigger("click");
		// }
		// if($(".sku_format").length>0){
		// 	$(".sku_format").eq(0).trigger("click");
		// }
	})

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
<!-- <div id="btm-downbar" style="position:relative; bottom:0;">
	<div id="downbar-close"></div>
	<a href="http://dwz.cn/tzm1314">
		<img src="/images/downbar1.png" />
	</a>
</div> -->
	<!-- <div id="header">
		<a href="javascript:history.back(-1);" class="header_back"></a>
		<p class="header_title">商品详情</p>

		<?php if ( $bLogin == false ){					// 如果用户未登录   ?>
			<a id="addFavor" href="/user_binding?dir=<?php echo $_SERVER['REQUEST_URI']; ?>" class="header_collections" title="收藏"></a>
	  	<?php }elseif($objProductInfo->status ==1){		// 如果不是下架商品   ?>
				<a id="addFavor" href="javascript:Favor(<?php echo $objProductInfo->id;?>);" title="收藏" class="header_collections <?php echo $is_fav == 1 ? 'active' : ''; ?>"></a>
	 	<?php }?>
	</div> -->

	<div class="pro_img_box">
		<div class="pro_header">
			<a href="javascript:history.back();" class="pro_header_back"></a>
			<a href="javascript:showDIv('bg2');" class="pro_header_share"></a>
		</div>
		<div id="img_warp">
			<div class="swiper-container">
		        <div class="swiper-wrapper">
		        	<?php if ( is_array( $imageList ) ){ ?>
						<?php foreach($imageList as $image){ ?>
							<div class="swiper-slide"><img src="<?php echo $site_image?>productFocusImages/<?php echo $image->images;?>" alt=""></div>
						 <?php } ?>
					<?php }else{  ?>
						<div class="swiper-slide"><img src="<?php echo $site_image?>product/<?php echo $objProductInfo->image;?>" alt=""></div>
					<?php } ?>
		        </div>
		        <div class="swiper-pagination"></div>
		    </div>
			<!-- <?php if(isset($seckillTimeDiff) && $seckillTimeDiff){ ?>
				<div class="seckillend" id="seckillend">
					<span id="seckillendtime"><span class="timenum">00</span>:<span class="timenum">00</span>:<span class="timenum">00</span></span>
				</div>
			<?php } ?> -->

			<script type="text/javascript">
				var swiper = new Swiper('#img_warp .swiper-container', {
					pagination: '.swiper-pagination',
        			paginationClickable: true
				});
			</script>
		</div>
	</div>

	<div class="pd_title_warp">
		<input type="hidden" id="sku_color_id" value="" />
		<input type="hidden" id="sku_farmat_id" value="" />
		<input type="hidden" id="sku_id" value="0" />

		<div id="pd_title_desc">
			<!-- <?php if( $objProductInfo->status == 0 ){ ?>
				<p>该商品已下架</p>
				<p><?php echo $objProductInfo->product_name; ?></p>
			<?php }elseif( $objProductInfo->activity_info->status == 0 ){ ?>
				<p>活动已结束</p>
				<p><?php echo $objProductInfo->product_name; ?></p>
			<?php }elseif( $objProductInfo->activity_info->status == 2 ){ ?>
				<p>活动即将开始</p>
				<p><?php echo $objProductInfo->product_name; ?></p>
			<?php }else { ?>
           	<?php } ?> -->
				<div class="title">
	                <div class="title1">
	                	<span style="color:#e61959"><!-- <?php echo $objShop->self_support == 1 ? '自营　' : ''; ?> --></span>
	                	<span class="self">自营</span>
	                	<?php echo $objProductInfo->product_name; ?>
	                </div>
	                <?php if ( $bLogin == false ){					// 如果用户未登录   ?>
						<a id="addFavor" href="/user_binding?act=user_bind" class="collections" title="收藏"></a>
				  	<?php }elseif($objProductInfo->status ==1){		// 如果不是下架商品   ?>
							<a id="addFavor" href="javascript:Favor(<?php echo $objProductInfo->id;?>);" title="收藏" class="collections <?php echo $is_fav == 1 ? 'active' : ''; ?>"></a>
				 	<?php }?>
				</div>
				<p class="sprice">
				
					￥<span id="buy_price"><?php echo sprintf('%.1f',$objProductInfo->distribution_price);?></span>
               
					<?php if ( isset($objProductInfo->selling_price) ){ ?>
						<span class="oldpricecon">
							<del class="oldprice">￥<?php echo sprintf('%.1f',$objProductInfo->selling_price);?></del>
						</span>
					<?php } ?>

					<!--<?php if ( isset($objProductInfo->tips) ){ ?>
						<span class="vicon"><?php echo $objProductInfo->tips; ?></span>
					<?php } ?>-->
				</p>
				<ul class="ensure">
					<li>正品全场3c包邮</li>
					<li>24小时内发货</li>
					<li>7天无理由退货</li>
				</ul>
		</div>
	</div>

	<?php if ( $sku_color_list != null ){ ?>
	<div id="chooseTxt2" onclick="skuOpen();">请选择颜色和规格</div>
	<?php } ?>

	<!-- <div class="pro_business">
		<div class="logo"><img src="<?php echo $site_image; ?>/shop/<?php echo $shop_info->images; ?>" /></div>
		<div class="right">
			<h3 class="name"><?php echo $objProductInfo->brand_name; ?></h3>
			<ul class="info">
				<li>商品评价：<font><?php echo sprintf( '%.1f', $shop_info->product_commt ); ?></font></li>
				<li>卖家服务：<font><?php echo sprintf( '%.1f', $shop_info->deliver_commt); ?></font></li>
				<li style="padding-right:0;">物流速度：<font><?php echo sprintf( '%.1f', $shop_info->logistics_commt); ?></font></li>
			</ul>

			<?php if ( isset($objProductInfo->activity_type) && $objProductInfo->activity_type == 3 ){ ?>
				<a href="/special_detail.php?aid=<?php echo $objProductInfo->activity_id; ?>">
					<span class="tm">特卖专场</span>
				</a>
			<?php } ?>
		</div>
	</div> -->

	<div class="pro_tab">
		<div class="pro_tab_title">
			<a href="product_detail.php?pid=<?php echo $objProductInfo->id;?>&act=desc" data-divId="#pro_raphic_main" class="active"><span>图文介绍</span></a>
			<a href="product_detail.php?pid=<?php echo $objProductInfo->id;?>&act=comment" data-divId="#pro_comment"><span>评论（<?php echo $commentNum;?>）</span></a>
		</div>
		<div class="pro_tab_item" id="pro_raphic" style="display:block;">
			<div class="pd_param_warp">
				<dl id="pd_param_desc">
					<dd>产品货号：　<?php echo $objProductInfo->product_num;?></dd>
					<dd>运费说明：　<?php echo ($objProductInfo->postage_type == 1) ? '包邮 (偏远地区除外)' : '不包邮';?></dd>
					<dd>是否电动：　<?php echo ($objProductInfo->is_power == 1) ? '是' : '否';?></dd>
					<dd>源自产地：　<?php echo $objProductInfo->location;?></dd>
					<dd>产品重量：　<?php echo $objProductInfo->weight;?>KG</dd>
				</dl>
				<div id="pd_param_icon">
					<img src="images/product/3c_icon.png" width="100%">
				</div>
			</div>

			<div id="pro_raphic_main" class="active"><!--图文详情--></div>

			<?php  if ( is_array($similar_products) ){  ?>
			<div style="background:#eeefef">
				<h3 class="pro_like"><div><i></i>猜你喜欢</div><hr/></h3>
				<div class="product_block_warp" style="margin-bottom:0;">
			        <ul>
                   		<?php foreach( $similar_products as $product ){ ?>
	                   		<li>
					        	<div class="product_block_main">
		                        	<a class="p_img_warp" href="/product_detail?pid=<?php echo $product->id;?>">
			                            <div class="square_img"><img src="<?php echo $site_image?>product/small/<?php echo $product->image;?>" alt="" /></div>
			                            <p><?php echo $product->product_name; ?></p>
			                        </a>

			                        <div class="p_desc_warp">
			                           <span>￥<?php echo number_format($product->distribution_price,1);?></span>
			                           <!-- <span class="discount"><?php echo $product->tips; ?></span> -->
			                        </div>
		                        </div>
	                  		</li>
						<?php } ?>
			        </ul>
				</div>
			</div>
			<?php } ?>
		</div>

		<div class="pro_tab_item" id="pro_comment"><!--买家口碑--></div>
	</div>


	
	<div style="height:45px;"></div>
	<div class="product_detail_foot_warp">
		<a class="foot_cart" href="cart.php"><span id='cart-tip'>0</span></a>
		<div class="foot_btn_warp">
			<?php if( ! $bLogin ){ ?>
    			<a class="addCart" href="/user_binding?act=user_bind; ?>">加入购物车</a>
	        <?php }else{ ?>
        		<?php if ( $objProductInfo->status == 1 ){ ?>
        			<?php if ( $sku_color_list != null ){ ?>
        				<a class="addCart" onclick="skuOpen();">加入购物车</a>
        			<?php }else{ ?>
        				<a class="addCart" onclick="sku_confirm(<?php echo $objProductInfo->id;?>);">加入购物车</a>
        			<?php } ?>
				<?php }?>
		</div>
		<span class="foot_price">￥<font id="buy_price2"><?php echo sprintf('%.1f',$objProductInfo->price);?></font></span>
		<div class="addCart_success">
			成功加入购物车
			<a href="cart.php">立即结算 &gt;</a>
		</div>
	</div>

	<div class="popup_sku">
		<div class="popup_sku_bg" onclick="skuClose()"></div>
		<div class="popup_sku_main">
			<div class="sku_pro_info">
				<img src="<?php echo $site_image?>product/small/<?php echo $objProductInfo->image;?>" width="60" height="60" onerror="this.onerror=null;this.src='http://weixinstorenew/res/images/default_big.png'">
				<div>
					<font style="color:#f78d1d;font-size:14px;">￥<span id="price_new" style="font-size:14px;"><?php echo sprintf('%.1f',$objProductInfo->distribution_price);?></span></font>
		            <i id="pro_discount" class="hidden"></i>
		            <div id="chooseTxt">请选择颜色和规格</div>
				</div>
				<a class="sku_close" title="关闭" href="javascript:skuClose();"></a>
			</div>

			<div class="sku_box">
				<?php if ( $sku_color_list != null ){ ?>
					<div class="product_sku_warp">
						<dl class="color_sku">
							<dt>产品颜色：</dt>
							<?php foreach( $sku_color_list as $info ){  ?>
								<dd>
									<a class='sku_color' data-value="<?php echo $info->Id; ?>" ><?php echo $info->value; ?></a>
								</dd>
							<?php } ?>
						</dl>
						<div class='clear'></div>
					</div>
				<?php } ?>

				<?php if ( $sku_format_list != null ){ ?>
					<div class="product_sku_warp">
						<dl class="format_sku">
							<dt>产品规格：</dt>
							<?php foreach( $sku_format_list as $info ){  ?>
								<dd>
									<a class='sku_format' data-value="<?php echo $info->Id; ?>" ><?php echo $info->value; ?></a>
								</dd>
							<?php } ?>
						</dl>
						<div class='clear'></div>
					</div>
				<?php } ?>
			</div>

			<div class="sku_buy">
				<a onclick="sku_confirm(<?php echo $objProductInfo->id;?>);" class="canChoose">确认</a>
			</div>
		</div>
		
	</div>
	<?php } ?>

	<div id="bg2" onclick="hideDiv('bg2');">
		<img src="images/guide_firend.png" alt="" style="position:fixed;top:0;right:16px;">
	</div><!--分享-->

	<?php  include "footer_web.php"; ?>

	<script language="javascript">
		$(function(){
			<?php if(isset($seckillTimeDiff) && $seckillTimeDiff){ ?>
			downcount(<?php echo $seckillTimeDiff;?>);
			<?php } ?>

			// $("#pro_raphic_main,#pro_comment").css("minHeight",$(window).height());
			var xhr = $.ajax({
				url: $(".pro_tab_title a:eq(0)").attr("href"),
				success: function(result){
					$("#pro_raphic_main").removeClass("active").html(result);
				}
			});
			$(".pro_tab_title a").on("click",function(){
				if(!!xhr){
					xhr.abort();		//取消未请求完成的ajax
				}

				var tabTop = $(".pro_tab").offset().top;
				$('html,body').animate({scrollTop: tabTop}, 100);

				var aUrl = $(this).attr("href"), aDivId = $(this).attr("data-divId");
				$(".pro_tab_title a").removeClass("active");
				$(this).addClass("active");
				if($(aDivId).hasClass("pro_tab_item")){
					$(".pro_tab_item").hide();
					$(aDivId).show();
				}else{
					$(".pro_tab_item").hide();
					$(aDivId).parents(".pro_tab_item").show();
				}
				$(aDivId).html("").addClass("active");
				xhr = $.ajax({
					url: aUrl,
					success: function(result){
						$(aDivId).removeClass("active").html(result);
						tabTop = $(".pro_tab").offset().top;
						$('html,body').animate({scrollTop: tabTop}, 100);
					}
				});
				return false;
			});

			$(window).scroll(function(event) {
				var tabTop = $(".pro_tab").offset().top;
				$(window).scrollTop()>tabTop ? $(".pro_tab_title").addClass("active") : $(".pro_tab_title").removeClass("active");
			});
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

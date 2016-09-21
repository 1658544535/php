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
</script>

<script type="text/javascript">
	$(function(){
		$("input:checkbox").each(function(index, el) {
			$(el).prop("checked",false);
		});
	});

	function del(id)
	{
		if ( confirm("确认将该商品移出购物车？") )
		{
			$.ajax({
				url:'cart.php?act=del&id=' + id,
				type:'POST',
				dataType: 'json',
				error: function(){
		     		alert('请求超时，请重新添加');
		    	},
		    	success: function(result)
		    	{
					if(result.code == "1")
					{
						alert(result.msg);
						window.location.href="/cart";
					}
					else
					{
						alert(result.msg);
					}
	    		}
			});
		}
	}

	function cart_buy(cid)
	{
		if($("#buy"+cid).prop("checked")){
			$("#buy"+cid).removeProp("checked");
			unSelAll();
		}else{
			$("#buy"+cid).prop("checked","checked");
		}
		show_buy_img(cid);
		calAmount();
	}


	// 减少指定产品数量
	function minus(obj){
		var _this = obj,
			_input = obj.next(),
			_price = obj.parents("dd").find(".cart_price");

		if(parseInt(_input.val()) > 1)
		{
			var buyNum = _input.attr("data-num");
			buyNum = parseInt(buyNum)-1;
			var specialnumber = (buyNum > 1) ? buyNum : 1;
			var cartid = _input.attr("data-cartid");

			$.ajax({
				url:'cart.php?act=change_num',
				data: {
					"cid": cartid,
					"type": "minus"
				},
				type:'POST',
				dataType: 'json',
				error: function(){
		     		alert('请求超时，请重新添加');
		    	},
		    	success: function(result)
		    	{
					if(result.code == "1")
					{
						_input.val(specialnumber)
							  .attr("data-num", specialnumber)
							  .attr("data-price", result.data.price);
						_price.text(parseFloat(result.data.price).toFixed(1));
					}
					else
					{
						if((result.data.num != "") && result.data.num > 0)
						{
							_input.val(result.data.num)
								  .attr("data-num", result.data.num);
						}
						alert(result.msg);
					}

					calShopCart(obj);
					calAmount();
	    		}
			});
		}
	}


	// 增加指定产品数量
	function plus(obj){
		var _this = obj,
			_input = obj.prev(),
			_price = obj.parents("dd").find(".cart_price");

		var buyNum = _input.attr("data-num"),
			specialnumber = parseInt(buyNum)+1,
			cartid = _input.attr("data-cartid");

		$.ajax({
			url:'cart.php',
			data:{
				"act": "change_num",
				"cid": cartid,
				"type": "plus"
			},
			type:'POST',
			dataType: 'json',
			error: function()
			{
				alert('请求超时，请重新添加');
			},
			success: function(result)
			{
				if(result.code == "1")
				{
					_input.val(specialnumber)
						  .attr("data-num", specialnumber)
						  .attr("data-price", result.data.price);
					_price.text(parseFloat(result.data.price).toFixed(1));
				}
				else
				{
					if((result.data.num != "") && result.data.num > 0)
					{
						_input.val(result.data.num)
							  .attr("data-num", result.data.num);
					}
					alert(result.msg);
				}

				calShopCart(obj);
				calAmount();
			}
		});
	}

	function setnum(obj){
		var _input = obj,
			_price = obj.parents("dd").find(".cart_price"),
			cartid = obj.attr("data-cartid");

		var newNum = _input.val();
		// if((op == "input") && (newNum == "")) return;
		if((newNum == "") || isNaN(newNum)) newNum = 1;
		newNum = parseInt(newNum);
		if(newNum < 1) newNum = 1;
		var buyNum = _input.attr("data-num");
		$.post('cart.php?act=change_num&cid='+cartid+'&type=set&n='+newNum, function(result){
			if(result.code == "1"){
				_input.val(newNum);
				_input.attr("data-num", newNum)
					  .attr("data-price", result.data.price);
				_price.text(parseFloat(result.data.price).toFixed(1));

				calShopCart(obj);
				calAmount();
			}else{
				if((result.data.num != "") && result.data.num > 0){
					_input.val(result.data.num);
					_input.attr("data-num", buyNum);
				}
			}
		}, "json");
	}

	function show_buy_img(cid){
		var _img = $("#buy_img"+cid);
		var _opt = (_img.attr("data-sel") == "true") ? {"src":"images/cart/choose.png","data-sel":"false"} : {"src":"images/shoppingCart_03.png","data-sel":"true"};
		_img.attr(_opt);
	}

	/**
	 * 全选
	 */
	function selAll(){
		var _obj = $("#btnSelAll");
		if(_obj.attr("data-sel") == "true"){//取消全选
			$("#all_buy_img").attr("src", "images/cart/choose.png");
			$("img[rel='proselitem']").attr({"src":"images/cart/choose.png","data-sel":"false"});
			$(":checkbox[rel='selbuy']").prop("checked",false);
			_obj.attr("data-sel", "false");
		}else{//全选
			$("#all_buy_img").attr("src", "images/shoppingCart_03.png");
			$("img[rel='proselitem']").attr({"src":"images/shoppingCart_03.png","data-sel":"true"});
			$(":checkbox[rel='selbuy']").prop("checked", true);
			_obj.attr("data-sel", "true");
		}
		calAmount();
	}

	/**
	 * 全选按钮取消全选
	 */
	function unSelAll(){
		$("#btnSelAll").attr("data-sel", "false");
		$("#all_buy_img").attr("src", "images/cart/choose.png");
	}

	/**
	 * 各单小计
	 */
	function calShopCart(obj){
		var totalAmount=0, totalNum=0;
		obj.parents("dl").find("dd").each(function(index, el) {
			var _input = $(el).find(".cart_number");
			var _num = parseInt(_input.attr("data-num"));
			totalNum += _num;
			totalAmount += _num * _input.attr("data-price");
		});
		obj.parents("dl").find(".total-price").text("￥" + parseFloat(totalAmount).toFixed(1));
	}

	/**
	 * 总额
	 */
	function calAmount(){
		var totalAmount = 0;
		$(":checkbox[rel='selbuy']:checked").each(function(index,el){
			var _input = $(el).parents("dd").find(".cart_number");
			var _price = _input.attr("data-price"),
				_number = _input.attr("data-num");
			totalAmount += _price * _number;
		});
		$("#t_price").text(parseFloat(totalAmount).toFixed(1));
	}

	$(function(){
		//页面加载完成全选
		selAll();
	});
</script>
</head>

<body>
	<div id="header">
		<a href="javascript:history.back(-1);" class="header_back"></a>
		<p class="header_title">购物车</p>
		<?php if($ShopCartList != null){ ?>
		  <a id="cart_eidt" href="javascript:;" class="header_btn_text">编辑</a>
	    <?php }?>
	</div>

	<?php if($ShopCartList == null){ ?>
		<div class="cart_empty_warp">
			<img id="buy_img" src="/images/shop_cart_bg.png" alt="" width="100"  style="width: 100px;"/>
			<p>购物车是空的，去淘几件中意的商品吧！</p>
			<a href="/index.php">去抢购</a>
		</div>
	<?php } ?>


	<?php
		if( $ShopCartList != null ){
			$sum_price = 0;
			$ii=0;
	?>
	<form action="cart.php" method="post">
		<input type="hidden" name="act" value="comfire" />
		<div class="cart_warp">

			<?php foreach($ShopCartList as $CartShopInfo ){   ?>

				<?php
					foreach( $CartShopInfo['info'] as $CartProductList )
					{
						$totalProNum = 0;
						$totalProPrice = 0;
				?>
						<dl>
							<!-- <dt>
								<div class="shop_checkbox" onclick="selShopAll(this)"><input type="checkbox" /></div>
								<a href="javascript:void(0);">
									<?php echo $CartProductList['activity_name']; ?>
								</a>
							</dt> -->

				<?php
						foreach( $CartProductList['product'] as $product )
						{
						
							$ii++;
							$totalProNum 	+= $product->num;
							$totalProPrice 	+= ($product->stock_price*$product->num);
			
							?>

					            <dd>
					            	<?php if ( $product->enable == 1 ){ ?>
					            		<input type="hidden" id="buy_type<?php echo $product->id;?>" value="1" />
					            	<?php } ?>
					            	<table border="0" cellpadding="0" cellspacing="0" class="shoppingCart-table">
					                	<tr>
					                    	<td class="pro_checkbox" rowspan="2" style="width:35px;text-align:center;">
					                    		
						                    		<div style="display:none;">
						                    			<input type="checkbox" class="hide_btn cart_checkbox" name="cid[]" 
						                    			        id="buy<?php echo $product->id;?>"
						                    					value="<?php echo $product->id ?>" rel="selbuy" />
						                    		</div>
						                    		<a href="javascript:cart_buy(<?php echo $product->id;?>);">
						                    			<img class="buy_imgs" id="buy_img<?php echo $product->id;?>" src="images/cart/choose.png" alt="" width="20" height="20" rel="proselitem" />
						                    		</a>
					                    		
					                    	</td>

					                        <td rowspan="2" style="width:20%; text-align:center;">
												<a href="/product_detail?pid=<?php echo $product->product_id;?>" class="shoppingCart-table-Pic02-border">
					                        		<img src="<?php echo $site_image?>product/small/<?php echo $product->product_image;?>" alt="" />
					                        		<!--<?php if ( $product->status == 0 ){ ?>
					                        			<div class="undercarriage"></div>
					                        		<?php } ?>-->
												</a>
					                        </td>

					                        <td colspan="2" style="padding-left:10px;">
												<p class="cart_pro_title">
													<a href="/product_detail?pid=<?php echo $product->product_id;?>&type=<?php echo $CartProductList['type']; ?>">
						                        	<?php
														$v=$product->product_name;  //以$v代表‘长描述’
														mb_internal_encoding('utf8');//以utf8编码的页面为例
														echo $v
													?>
													</a>
												</p>
											

												<?php if ( $product->sku_link_id > 0 ){ ?>
													<p class="cart_pro_attr"><?php echo $product->sku_info->sku_long_desc; ?></p>
												<?php } ?>
					                        </td>
					                    </tr>
										<tr>
											<td class="shoppingCart-table-R-quantity" style="font-size:10px; padding-left:10px;" >
											
													<a class="cart_minus" href="javascript:;"
														data-productid="<?php echo  $product->product_id;?>"
														data-cartid="<?php echo $product->id;?>">-</a>

													<input type="text" class="cart_number shoppingCart-table-R-number"
														value="<?php echo $product->num;?>"
														data-productid="<?php echo  $product->product_id;?>"
														data-cartid="<?php echo $product->id;?>"
														data-price="<?php echo $product->stock_price;?>"
														data-num="<?php echo $product->num;?>" />

													<a class="cart_plus" href="javascript:;"
														data-productid="<?php echo  $product->product_id;?>"
														data-cartid="<?php echo $product->id;?>">+</a>
												
											</td>
											<td style="text-align:right;">
												<!-- <span style="color:#e61959;"><?php echo $ActivityType[$product->type]; ?></span> -->
												<p style="color:#db0a25">￥<span class="cart_price"><?php echo number_format($product->stock_price,1);?></span></p>
											</td>
										</tr>
										<tr>
											<td colspan="4" align="right">
												<a class="cart_del" style="display:none;" onclick='del(<?php echo $product->id;?>)'>删除</a>
											</td>
										</tr>
					                </table>
								</dd>
							<?php } ?>
				                <div style="margin-top:-1px;height:40px; line-height:40px; background:#fff;border-top:1px solid #eeefef;">
				                	<p style="float:right; padding-right:10px; color:#1a1a1a;">小计<!-- (共 <span id="icarttn_<?php echo $product->activity_id;?>"><?php echo $totalProNum;?></span> 件)： --> 
				                		<span id="number<?php echo $product->activity_id;?>" class="number total-price" style="color:#db0a25;font-size:13px;" >￥<?php echo sprintf('%.1f',$totalProPrice)?></span>
				                		<!-- &nbsp;(含运费<?php echo sprintf('%.1f',$espress_price); ?>元) -->
				                	</p>
				                	<p style="float:right; padding-right:10px; color:#666;">
				                		<?php
				                			if ( $CartProductList['type'] == 3 )
				                			{
				                				if ( $totalProPrice >= $CartProductList['discount_context']['om'] )
				                				{
				                					switch( $CartProductList['discount_type'] )
					                				{
					                					case 1:
															echo '满减(满'. $CartProductList['discount_context']['om'] .')　-'. $CartProductList['discount_context']['m'];
															$totalProPrice = $totalProPrice - $CartProductList['discount_context']['m'];
					                					break;

					                					case 2:
					                						echo '满减(满'. $CartProductList['discount_context']['om'] .'件)　打'. $CartProductList['discount_context']['m'] .'折';
					                						$totalProPrice = $totalProPrice * ($CartProductList['discount_context']['m'] * 0.1);
					                					break;
					                				}
				                				}
				                			}
				                		?>
				                	</p>
				                </div>
							</dl>
				<?php } ?>
			<?php } ?>
		</div>

		<?php if( $ShopCartList != null ){ ?>
			<div style="height:55px;"></div>
			<div class="shoppingCart-foot">
				<input type="hidden"  id="all_price" name="all_price" value="<?php echo $sum_price; ?>" />
				<div class="shoppingCart-foot-L">
					<?php if($ShopCartList != null){ ?>
						<a href="javascript:selAll();" id="btnSelAll">
							<img style="" id="all_buy_img" src="images/cart/choose.png" width="20" />
							<p>全选</p>
						</a>
					<?php } ?>
				</div>
				<div class="shoppingCart-foot-R">
					<input name="submit" type="submit" class="shoppingCart-foot-R-btn" value="结算" />
					<div>
						合计：<font style="color:#db0a25;">￥<span id="t_price"><?php echo number_format(0,1);?></span></font>
						<!-- <p>为您节省：￥<span>0.0</span></p> -->
					</div>
				</div>
			</div>
		<?php } ?>
	</form>
	<?php } ?>

	<?php include "footer_web.php";?>

	<script>
		$(function(){
			//编辑事件
			$("#cart_eidt").bind("click", function(){
				var txt = $(this).html(),
					_this = $(this);
				if(txt == "编辑"){
					$(".cart_del").show();
					_this.html("完成");
				}else{
					$(".cart_del").hide();
					_this.html("编辑");
				}
			});

			//增加事件
			$(".cart_plus").bind("click", function(){
				plus($(this));
			});

			//减少事件
			$(".cart_minus").bind("click", function(){
				minus($(this));
			});

			//减少事件
			$(".cart_number").bind("change", function(){
				setnum($(this));
			});



		})
	</script>
</body>
</html>
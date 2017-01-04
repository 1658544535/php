<?php include_once('header_web.php');?>
<?php include_once('wxshare_web.php');?>
<body>
	<form action="order.php" method="post" onsubmit="return submitPay()" style="display:block;width:100%;height:100%;">
		<div class="page-group" id="page-orderCofirm">
			<div id="page-nav-bar" class="page page-current">
				<header class="bar bar-nav">
					<a class="button button-link button-nav pull-left back" href="javascript:history.back(-1);">
						<span class="icon icon-back"></span>
					</a>
					<h1 class="title">确认订单</h1>
				</header>

				<div class="content native-scroll" style="bottom:2.75rem;">
					<?php if(!$canDispatch){ ?>
						<div class="oc-tips themeColor">当前地址不在配送范围内</div>
					<?php } ?>

					<section class="oc-adress">
						<a href="/address?act=choose">
							<?php if ( $address == NULL ){ ?>
								<div>您的地址信息为空，点击进行添加</div>
							<?php }else{ ?>
								<div><?php echo $address['name']; ?>&nbsp;&nbsp;&nbsp;<?php echo $address['tel']; ?></div>
								<div><?php if(!$canDispatch){ ?><strong>（无法配送至该地址）</strong><?php } ?><?php echo $address['address']; ?></div>
							<?php } ?>
						</a>
					</section>

					<?php
					if($_SESSION['order']['type'] == 'guess'){
						$tipTitle = '拼团商品';
						$tipPrice = '拼团价';
					}else{
						$tipTitle = '拼团商品';
						$tipPrice = '拼团价';
					}
					?>

					<section class="freeList proTips-2 oc-pro">
						<h3 class="title1"><?php echo $tipTitle;?></h3>
						<ul class="list-container">
							<li><a href="groupon.php?id=<?php echo $grouponId;?>">
								<div class="img"><img src="<?php echo $info['products']['productImage'];?>"></div>
								<div class="info">
									<div class="name"><?php echo $info['products']['productName'];?></div>
									<div class="price">
										<!-- <div class="btn">商品详情</div> -->
										<?php echo $tipPrice;?>：<span class="price1" id="price">￥<?php echo $info['products']['price'];?></span>
										<!-- <span class="price2">￥<?php echo $info['products']['sellingPrice'];?></span> -->
									</div>
								</div>
							</a></li>
						</ul>
						<input type="hidden" name="skuid" value="<?php echo $info['products']['skuLinkId'];?>" />
						<div class="num">
							<span class="label">数量</span>
							<!-- <div class="quantity">
								<span class="minus">-</span>
								<input type="text" id="number" name="num" value="<?php echo $info['allCount'];?>" />
								<span class="plus">+</span>
							</div> -->
							<input type="hidden" id="number" name="num" value="<?php echo $info['allCount'];?>" />
							<span class="txt">共<?php echo $info['allCount'];?>件</span>
						</div>
						<div class="message">
							<span class="label">买家留言</span>
							<div class="txt">
								<input type="text" name="buyer_message" placeholder="对本次交易的说明" />
							</div>
						</div>
						<div class="subTotal">合计：<font class="themeColor">￥<span class="price" id="totol-amount"><?php echo $info['sumPrice'];?></span></font>（全场包邮）</div>
					</section>

					<section class="oc-coupon">
						<div>使用优惠券</div>
						<?php if(!empty($cpn)){ ?>
							<!-- <div>券码<b id="coupon-number"><?php echo $cpn['couponNo'];?></b></div> -->
							<span class="price">优惠<b id="coupon-price"><?php echo $cpn['m'];?></b>元</span>
							<input type="hidden" id="coupon-number-input" name="cpnno" value="<?php echo $cpn['couponNo'];?>" />
						<?php } ?>
					</section>

					<section class="oc-pay">
						<ul class="list">
							<li>
								<input type="radio" name="payWay" checked value="8"/>
								<img src="images/pay-wx.png" />
								<p>微信支付</p>
								<span class="label">推荐</span>
							</li>
							<li>
								<input type="radio" name="payWay" value="4"/>
								<img src="images/user-wallet.png" />
								<p>使用钱包金额</p>
							</li>
						</ul>
					</section>

				</div>

				<div class="oc-footer">
					实付款：<font class="themeColor">￥<span class="price" id="fact-amount"><?php echo $info['sumPrice'];?></span></font>
					<input type="submit" value="立即支付" class="btn<?php if(!$canDispatch){ ?> gray<?php } ?>" />
				</div>
			</div>
	        <div class="popup popup-oc-coupon">
	            <div>
	                <a href="javascript:;" class="close-popup"></a>
	                <ul></ul>
	                <script id='tpl_ocCoupon' type="text/template">
					<%if(data["data"].length>0){%>
	                	<%for(var i=0;i<data["data"].length;i++){%>
	                	<li>
	                        <div class="freeCoupon" data-number="<%=data["data"][i]["couponNo"]%>" data-price="<%=data["data"][i]["m"]%>">
	                            <div class="info">
	                                <div class="name"><%=data["data"][i]["couponName"]%></div>
	                                <div class="tips"><%=data["data"][i]["couponNo"]%></div>
	                                <div class="time">有效期: <%=data["data"][i]["validStime"]%>-<%=data["data"][i]["validEtime"]%></div>
	                            </div>
	                            <div class="price"><div>￥<span><%=data["data"][i]["m"]%></span></div></div>
	                        </div>
	                    </li>
	                    <%}%>
					<%}else{%>
						<li><div class="tips-null">暂无优惠券</div></li>
					<%}%>
	                </script>
	            </div>
	        </div>
		</div>
	</form>

	<script type="text/javascript">
	$(document).on("pageInit", "#page-orderCofirm", function(e, pageId, page) {
		priceTotal();
    	//数量增减
    	$(".quantity .minus").on("click", function(){
    		var num = parseInt($(this).next().val());
    		if(num>1){
    			$(this).next().val(--num);
    		}else{
    			return false;
    		}
    		priceChange();
    	});
    	$(".quantity .plus").on("click", function(){
    		var num = parseInt($(this).prev().val());
    		$(this).prev().val(++num)
    		priceChange();
    	});
    	//选择优惠券
    	$(".oc-coupon").on("click", function(){
    		$.showIndicator();
    		$.ajax({
    			url: "api_action.php?act=coupon_valid",
	        	type: 'POST',
	        	dataType: 'json',
	        	data: {"pid":<?php echo $info['products']['productId'];?>,"amount":$("#totol-amount").text()},
	        	success: function(res){
	        		var bt = baidu.template;
	    			baidu.template.ESCAPE = false;
	    			var html=bt('tpl_ocCoupon',res);
	    			$(".popup-oc-coupon ul").html(html);
	    			$.hideIndicator();
		        	$.popup('.popup-oc-coupon');
	        	}
    		});
    	});
    	$(document).on("click", ".popup-oc-coupon .freeCoupon", function(){
    		var number = $(this).attr("data-number"),
    			price = $(this).attr("data-price");
    		// if($(".oc-coupon #coupon-number").length>0){
    		// 	$("#coupon-number").html(number);
    		// 	$("#coupon-price").html(price);
    		// 	$("#coupon-number-input").val(number);
    		// }else{
    		// 	var html = '<div>券码<b id="coupon-number">'+ number +'</b></div>'
		    //              + '<span class="price">优惠<b id="coupon-price">'+ price +'</b>元</span>'
		    //              + '<input type="hidden" id="coupon-number-input" name="cpnno" value="'+ number +'" />';
		    //     $(".oc-coupon").append(html);
    		// }
    		if($(".oc-coupon #coupon-number-input").length>0){
    			$("#coupon-price").html(price);
    			$("#coupon-number-input").val(number);
    		}else{
    			var html = '<span class="price">优惠<b id="coupon-price">'+ price +'</b>元</span>'
		                 + '<input type="hidden" id="coupon-number-input" name="cpnno" value="'+ number +'" />';
		        $(".oc-coupon").append(html);
    		}
    		$.closeModal('.popup-oc-coupon');
    		priceTotal();
    	});

		function priceChange(){
			var num = parseInt($("#number").val());
			var price = parseFloat($("#price").html());
			$("#totol-amount,#fact-amount").html(parseFloat(num*price).toFixed(2));
			priceTotal();
		}

		function priceTotal(){
			var totalPrice = parseFloat($("#totol-amount").html());
			var couponPrice = $("#coupon-price")[0] ? parseFloat($("#coupon-price").html()) : 0;
			if(!couponPrice){
				couponPrice=0;
			}
			totalPrice = totalPrice - couponPrice;
			totalPrice<0 ? totalPrice=0 : '';

			$("#fact-amount").html(totalPrice.toFixed(2));
		}
    });
	var clickSubmit = true;
	function submitPay(e){
		<?php if(empty($address)){ ?>
			$.toast("请设置收货地址");
			return false;
		<?php } ?>

		<?php if(!$canDispatch){ ?>
			return false;
		<?php } ?>
		var submit = clickSubmit;
		if(clickSubmit) clickSubmit = false;
		return submit;
	}
	</script>
</body>

</html>

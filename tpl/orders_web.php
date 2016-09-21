<!doctype html>
<html lang="zh">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1, user-scalable=no" />
<meta name="format-detection" content="telephone=no" />
<title><?php echo $site_name;?></title>
<link href="/css/common.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="/js/jquery-1.11.0.min.js"></script>
<script src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>
<script type="text/javascript" src="/js/wxshare.js"></script>

<script>
	wxshare( <?php echo WXJSDEBUG;?>, '<?php echo WXJSAPPID;?>', <?php echo WXJSTIMESTAMP;?>, '<?php echo WXJSNONCESTR;?>', '<?php echo WXJSSIGNATURE;?>', '<?php echo WEBLOGO;?>', '<?php echo $SHARP_URL;?>', '<?php echo WEBTITLE;?>', '<?php echo WEBDESC;?>' )
</script>
<script type="text/javascript">

function del(id)
{
	if ( confirm("确认将删除该订单么？") )
	{
		$.ajax({
			url:'/orders?act=del&return_url=<?php echo $return_url;?>&oid=' + id,
			type:'GET',
			dataType:'json',
	    	success: function(result){
	    		alert( result.msg );
	    		if ( result.code > 0 )
	    		{
	    			window.location.reload();
	    		}
	    	}
		});
	}
}

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

function cancel(id)
{
	if ( confirm("确定取消该订单吗?") )
	{
		$.ajax({
			url:'/orders?act=cancel&return_url=<?php echo $return_url;?>&oid=' + id,
			type:'GET',
			dataType:'json',
	    	success: function(result){
	    		alert( result.msg );
	    		if ( result.code > 0 )
	    		{
	    			window.location.reload();
	    		}
	    	}
		});
	}
}


function confirm_order(id)
{
	if ( confirm("确定收货?") )
	{
		$.ajax({
			url:'/orders?act=confirm&oid=' + id,
			dataType:'json',
	    	success: function(result){
	    		alert( result.msg );
	    		if ( result.code > 0 )
	    		{
	    			window.location.reload();
	    		}
	    	}
		});
	}
}

</script>
</head>

<body>
	<div id="header">
	    <a href="/user.php" class="header_back"></a>
	    <p class="header_title">我的订单
			<!-- <?php
	   			if($sid==1)
	   			{
	   				echo "待付款";
	   			}
	   			else if($sid==2)
	   			{
	   				echo "待发货";
	   			}
	   			else if($sid==3)
	   			{
	   				echo "待收货";
	   			}
	   			else if($sid==4)
	   			{
	   				echo "待评价";
	   			}
	   			//else if($sid==5)
	   			else if( $act=="return" )
	   			{
	   				echo "退货 / 退款";
	   			}
	   			else
	   			{
	   				echo "全部订单";
	   			}
	   		?> -->
	    </p>
	</div>

	<div class="order_tabs" data-sid="<?php echo $sid; ?>">
		<a href="orders?sid=0&return_url=user">全部订单</a>
		<a href="orders?sid=1&return_url=user">待付款</a>
		<a href="orders?sid=2&return_url=user">待发货</a>
		<a href="orders?sid=3&return_url=user">待收货</a>
		<a href="orders?sid=4&return_url=user">待评价</a>
	</div>

	<?php if ( $ordersList == null ){ ?>
		<div class="order_empty" >
			<dl>
				<dd><img src="/images/order/orderlist_icon.png" width="100" /></dd>
				<dd>暂无订单</dd>
			</dl>
		</div>
	<?php }else{ ?>
		<div class="order_pro_list order_list_new">
			<ul>
				<?php foreach( $ordersList as $OrderInfo ){
					?>
					<li>
						<a href="/orders?act=info&oid=<?php echo $OrderInfo['id']; ?>">
							<h3>
								<!-- <p><?php echo $OrderInfo['activity_name']; ?></p> -->
								<label>
									<!-- <?php if($OrderInfo['order_status']==1){ ?>
										<input class="hide" type="checkbox" name="" />
										<i class="ckx"></i>
									<?php } ?> -->
									订单编号：<?php echo $OrderInfo['order_no'];?>
								</label>

								<?php if( $OrderInfo['available_productnum'] > 0 ){  ?>
									<span class="order_state <?php if($OrderInfo['order_status']==2){echo 'c-orange';}?>"><?php echo $OrderInfo['order_status_desc']; ?></span>
								<?php }else{ ?>
									<span class="order_state">订单售后处理中</span>
								<?php } ?>
							</h3>
							<?php
								$ProductPrice 	= 0;	// 总价格
								$ProductNum 	= 0;	// 总件数
								foreach( $OrderInfo['info'] as $ProductInfo ){

									?>
									<table border="0" cellpadding="0" cellspacing="0">
										<tbody><tr>
											<td rowspan="2" width="80">
												<img src="<?php echo $site_image ; ?>product/small/<?php echo $ProductInfo['product_image']; ?>">
											</td>
											<td class="order_pro_title"><?php echo $ProductInfo['product_name']; ?></td>
											<td rowspan="2" width="50" align="right">
												<p style="color:#db0a25;">￥<?php echo sprintf( '%.1f', $ProductInfo['stock_price'] ); $ProductPrice += $ProductInfo['stock_price']; ?></p>
												<span style="color:#b2b2b2">×<?php echo $ProductInfo['num']; $ProductNum += $ProductInfo['num']; ?></span>
											</td>
										</tr>
										<tr>
											<td style="vertical-align:bottom;color:#b2b2b2;"><?php echo $ProductInfo['sku_desc']; ?></td>
										</tr>
									</tbody></table>

							<?php } ?>

							<div class="subtotal">
								<!-- <span>共<?php echo $ProductNum; ?>件产品</span> -->
								<span style="padding-left:5px;font-size:12px;">小计：</span>
								<span style="padding:0 5px 0 0;color:#db0a25;font-size:13px;">￥<?php echo  sprintf( '%.1f', $ProductPrice + $OrderInfo['espress_price'] ); ?></span>
								(含运费<?php echo sprintf( '%.1f', $OrderInfo['espress_price'] ); ?>)
							</div>
						</a>
						<?php  if( $OrderInfo['available_productnum'] > 0 ){  ?>
							<div class="order_btn">
								<?php if ( $OrderInfo['order_status'] == 1 ){ ?>
									<a href="javascript:void(0);"  onclick="cancel(<?php echo $OrderInfo['id']; ?>)">取消订单</a>
									<a href="/orders?act=paid&oid=<?php echo $OrderInfo['id']; ?>" class="red">立即付款</a>
								<?php } ?>

								<?php if ( $OrderInfo['order_status'] == 2 ){ ?>
									<a href="javascript:void(0);">待发货</a>

								<?php } ?>

								<?php if ( $OrderInfo['order_status'] == 3 || $OrderInfo['order_status'] == 4) { ?>
									<a href="/orders?act=express&oid=<?php echo $OrderInfo['id']; ?>&return=<?php echo $_SERVER['REQUEST_URI']; ?>">查看物流</a>
								<?php } ?>

								<?php if ( $OrderInfo['order_status'] == 3 ){ ?>
									<a href="javascript:void(0);" onclick='confirm_order(<?php echo $OrderInfo['id']; ?>)'  class="red">确认收货</a>
								<?php } ?>

								<?php if ( $OrderInfo['order_status'] == 4 && $OrderInfo['available_productnum'] > 0  ){ ?>
									<a href="/orders?act=comment&oid=<?php echo $OrderInfo['id']; ?>" class="red">订单评价</a>
								<?php } ?>

								<?php if ( $OrderInfo['order_status'] == 5 ){ ?>
									<a href="javascript:void(0);"  onclick="del(<?php echo $OrderInfo['id']; ?>)">删除订单</a>
									<a href="javascript:void(0);">已评价</a>
								<?php } ?>
							</div>
						<?php } ?>
					</li>
				<?php } ?>
			</ul>
		</div>
	<?php } ?>

	<!-- <div style="height:55px;"></div>
	<div class="order_merge">
		<input type="submit" value="合并付款" />
	</div> -->

<script language="javascript">
	var pageInfo = {"page":1,"showoid":0,"orderpage":1,"scrolltop":0};
	var page = 1;
	var totalPage = <?php echo $ordersList['PageCount'] ? intval($ordersList['PageCount']) : 0; ?>;
	var gPageInfo = getLocalInfo();

	$(function(){
		if((typeof(gPageInfo) == "undefined") || (gPageInfo == null) || (gPageInfo == "")){
			saveLocalInfo();
		}else{//从产品页返回
			gPageInfo.page = parseInt(gPageInfo.page);
			gPageInfo.orderpage = parseInt(gPageInfo.orderpage);
			if(gPageInfo.orderpage > 1){
				var loadItemCount = (gPageInfo.orderpage)*20;//额外加载被点击产品所在页数的产品
				pageInfo.page = 0;
				show(loadItemCount);
			}
		}

		//选择合并订单
		// $(".order_list_new.order_pro_list li h3 label input").bind("change", function(){
		// 	if($(this).is(":checked")){
		// 		$(this).next().addClass("ckx-select");
		// 	}else{
		// 		$(this).next().removeClass("ckx-select");
		// 	}
		// });

		//tab
		var tabIndex = parseInt($(".order_tabs").attr("data-sid"));
		$(".order_tabs>a").eq(tabIndex).addClass("active");

	});

	function preShow(oid){
		var _obj = $("#list-order-item-"+oid);
		pageInfo.showoid = _obj.attr("pitem");
		pageInfo.orderpage = _obj.attr("curpage");
		pageInfo.scrolltop = $(document).scrollTop();
		saveLocalInfo();
	}

	function saveLocalInfo(){
		localStorage.setItem("orderpageinfo", JSON.stringify(pageInfo));
	}

	function getLocalInfo(){
		return JSON.parse(localStorage.getItem("orderpageinfo"));
	}

	function show(persize){
		var setSize;
		$("#progressIndicator").show();
		var url = "ajaxtpl/ajax_user_order.php?sid=<?php echo $sid;?>&page="+(parseInt(pageInfo.page)+1);
		if(typeof(persize) != "undefined"){
			url += "&rep=1&per="+persize;
			setSize = true;
		}else{
			setSize = false;
		}
		$.get(url, function(_html){
			$("#progressIndicator").hide();
			_html = $.trim(_html);
			if(_html == ""){
				alert('已经到达底部！');
				$("#load_btn").hide();
			}else{
				if(setSize) $("#initRender").hide();
				$("#page-bot").before(_html);
				pageInfo.page++;
				pageInfo.showoid = 0;
				if(setSize) pageInfo.page = gPageInfo.orderpage;
				if(pageInfo.page >= totalPage) $("#load_btn").hide();
				if(gPageInfo.scrolltop > 0) $(document).scrollTop(gPageInfo.scrolltop);
				saveLocalInfo();
			}
		});
	}
</script>

<?php include "footer_web.php"; ?>
</body>
</html>

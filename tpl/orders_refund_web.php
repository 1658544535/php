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

</head>

<body>
	<div id="header">
	    <a href="javascript:history.go(-1);" class="header_back"></a>
	    <p class="header_title"> 退款维权 </p>
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
				<?php foreach( $ordersList as $ProductInfo ){  ?>
					<li>
						<h3>
							<a href="#"><?php echo $ProductInfo->shop_name; ?></a>
							<span class="order_state">
							<?php
								switch($ProductInfo->status)
								{
									case 1:
										echo '审核中';
									break;

									case 2:
										echo '请退货';
									break;

									case 3:
										echo '退货中';
									break;

									case 4:
										echo '退货成功';
									break;

									case 5:
										echo '退货失败';
									break;

									case 6:
										echo '审核失败';
									break;
								}
							?>
							</span>
						</h3>

						<a href="/orders?act=refund_info&id=<?php echo $ProductInfo->id; ?>">
							<table border="0" cellpadding="0" cellspacing="0">
								<tbody><tr>
									<td rowspan="2" width="80">
										<img src="<?php echo SITE_IMG; ?>product/small/<?php echo $ProductInfo->product_image; ?>">
									</td>
									<td class="order_pro_title"><?php echo $ProductInfo->product_name; ?></td>
									<td rowspan="2" width="50" align="right">
										<p style="color:#333;">￥<?php echo sprintf( '%.1f', $ProductInfo->stock_price ); ?></p>
										<span>×<?php echo $ProductInfo->refund_num; ?></span>
									</td>
								</tr>
								<tr>
									<td style="vertical-align:bottom"></td>
								</tr>
							</tbody></table>
						</a>

					</li>
				<?php } ?>

			</ul>
		</div>
	<?php } ?>

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

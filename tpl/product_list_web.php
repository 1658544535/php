<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="zh-CN">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta charset="utf-8" name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" />
<title><?php echo $site_name;?></title>
<link href="css/index3.css" rel="stylesheet" type="text/css" />
<link href="/css/common.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="js/jquery-1.4.2.min.js"></script>
<script type="text/javascript" src="js/jquery.cycle.all.js"></script>
<script type="text/javascript" src="js/jquery.faragoImageAccordion.js"></script>
<script src="/js/lazy/jquery.lazyload.min.js" type="text/javascript"></script>
<script src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>
<script type="text/javascript" src="/js/wxshare.js"></script>
<script>
	wxshare( <?php echo WXJSDEBUG;?>, '<?php echo WXJSAPPID;?>', <?php echo WXJSTIMESTAMP;?>, '<?php echo WXJSNONCESTR;?>', '<?php echo WXJSSIGNATURE;?>', '<?php echo WEBLOGO;?>', '<?php echo $SHARP_URL;?>', '<?php echo WEBTITLE;?>', '<?php echo WEBDESC;?>' )
</script>
</head>

<body>
	<div id="header">
		<dl id="title_warp">
			<dd>
				<a href="javascript:window.history.back(-1);">
				<img src="/images/index/icon-back.png" />
				</a>
			<dd class="page-header-title">
				<?php
			    if($is_new==1){
			    	echo "新品快订";}
				elseif( isset($actTitle)){
					echo $actTitle;
				}else{
					echo "商品列表";
				}
				?>
			</dd>
			<dd><!--<img src="/images/index/icon-back.png" />--></dd>
		</dl>
	</div>
   	<div class="nr_warp">
		<?php if( $productList == null ){ ?>
			<div class="order_empty" >
				<dl>
					<dd><img src="/images/order/orderlist_icon.png" width="100" /></dd>
					<dd>暂无商品</dd>
					<dd>
						<a href="/product?act=top">
							<img src="/images/order/go_icon.png" width="130" />
						</a>
					</dd>
				</dl>
			</div>
		<?php }else{ ?>

			<div class="product_block_warp">
		        <dl>
					<div id="initRender">
							<?php foreach($productList as $product){ ?>
								<a href="/product_detail?product_id=<?php echo $product->id;?>" pitem="<?php echo $product->id;?>" onclick="preShow(this)" curpage="1">
									<dd>
										<div class="p_img_warp">
											<img class="lazyload" data-original="<?php echo $site_image?>/product/small/<?php echo $product->image;?>" />
										</div>

										<div class="p_desc_warp">
											<p>
												<?php
													$v=&$product->product_name;  //以$v代表‘长描述’
													mb_internal_encoding('utf8');//以utf8编码的页面为例
													echo (mb_strlen($v)>10) ? mb_substr($v,0,10).'...' : $v;
												?>
											</p>

											<p>￥<?php echo number_format($product->distribution_price,1);?></p>
										</div>
									</dd>
								</a>
							<?php } ?>
					</div>
					<div id="page-bot"></div>
					<div class='clear'></div>
		        </dl>
		    </div>
		<?php } ?>
	<div id="progressIndicator" style="width:320px;text-align: center; display: none;">
		<img width="85" height="85" src="images/ajax-loader-85.gif" alt="">
		<span id="scrollStats" style="font-size: 70%; width: 80px; text-align: center; position: absolute; bottom: 25px; left: 2px;"></span>
	</div>
</div>

<br />
<br />
<br />
<?php include "footer_web.php"; ?>
<br />
<br />
<br />
<?php include "footer_menu_web_tmp.php"; ?>
<script language="javascript">
	var pageInfo = {"page":1,"showproid":0,"propage":1,"scrolltop":0};
	var page 	= <?php echo (isset($_SESSION["page"]) && ($_SESSION["page"] > 0) ) ? $_SESSION["page"] : 1; ?>;
	var totalPage = <?php echo $productList['PageCount'] ? intval($productList['PageCount']) : 0; ?>;
	var gPageInfo = getLocalInfo();

	$(function(){
		if((typeof(gPageInfo) == "undefined") || (gPageInfo == null) || (gPageInfo == "")){
			saveLocalInfo();
		}else{//从产品页返回
			gPageInfo.page = parseInt(gPageInfo.page);
			gPageInfo.propage = parseInt(gPageInfo.propage);
			if(gPageInfo.propage > 1){
				var loadItemCount = (gPageInfo.propage)*20;//额外加载被点击产品所在页数的产品
				pageInfo.page = 0;
				show(loadItemCount);
			}
		}
	});

	function preShow(obj){
		var _obj = $(obj);
		pageInfo.showproid = _obj.attr("pitem");
		pageInfo.propage = _obj.attr("curpage");
		pageInfo.scrolltop = $(document).scrollTop();
		saveLocalInfo();
	}

	function saveLocalInfo(){
		localStorage.setItem("pageinfo", JSON.stringify(pageInfo));
	}

	function getLocalInfo(){
		return JSON.parse(localStorage.getItem("pageinfo"));
	}

	function show(persize){
		var setSize;
		$("#progressIndicator").show();
		var url = "ajaxtpl/ajax_product_new.php?act=<?php echo $pact;?>&category_id=<?php echo $type;?>&key=<?php echo $key;?>&pid=<?php echo $types;?>&is_new=<?php echo $is_new;?>&sell=<?php echo $sell;?>&is_introduce=<?php echo $is_introduce;?>&page="+(parseInt(pageInfo.page)+1);
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
				//$("#load_btn").hide();
			}else{
				if(setSize) $("#initRender").hide();
				$("#page-bot").before(_html);
				pageInfo.page++;
				pageInfo.showproid = 0;
				if(setSize) pageInfo.page = gPageInfo.propage;
				if(pageInfo.page >= totalPage) $("#load_btn").hide();
				if(gPageInfo.scrolltop > 0) $(document).scrollTop(gPageInfo.scrolltop);
				saveLocalInfo();
			}
		});
	}
</script>

</body>
</html>
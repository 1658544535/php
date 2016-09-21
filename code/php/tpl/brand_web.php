<!doctype html>
<html lang="zh">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1, user-scalable=no" />
<title><?php echo $site_name;?></title>
<link href="/css/common.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="/js/jquery-1.11.0.min.js"></script>
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
		<a href="/" class="header_back"></a>
		<p class="header_title"><?php echo isset($actTitle) ? $actTitle : "商品列表"; ?></p>
	</div>

	<?php if ( $isShowBar ){ ?>
		<div class="pro_list_sort">
			<a href="<?php echo $url; ?>">新品</a>
			<a id="col_price" href="<?php echo $url . $ColUrl['price']; ?>">价格<i></i></a>
			<a id="col_num" href="<?php echo $url . $ColUrl['num']; ?>">销量<i></i></a>
			<a id="col_hits" href="<?php echo $url . $ColUrl['hits']; ?>">人气<i></i></a>
		</div>
	<?php } ?>

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

   	<div class="nr_warp">
		<?php if( $BrandList['DataSet'] == null ){ ?>
			<div class="order_empty" >
				<dl>
					<dd><img src="/images/order/orderlist_icon.png" width="100" /></dd>
					<dd>暂无商品</dd>
				</dl>
			</div>
		<?php }else{ ?>

			<div class="product_block_warp">
				<div id="initRender">
		        	<ul>
						<?php foreach($BrandList['DataSet'] as $brand){
						 ?>
							<li>
								<div class="product_block_main">
									<a class="p_img_warp" href="/product_detail?pid=<?php echo $brand->id;?>" pitem="<?php echo $brand->id;?>" onclick="preShow(this)" curpage="1">
										<div class="square_img"><img class="lazyload" data-original="<?php echo $site_image?>product/small/<?php echo $brand->image;?>" /></div>
										<p>
											<?php
												if(empty($brand->productName)){
													$v =& $brand->product_name;  //以$v代表‘长描述’
												}else {
													$v=&$brand->productName;
												}
												mb_internal_encoding('utf8');//以utf8编码的页面为例
												echo $v;
											?>
										</p>
									</a>

			                        <div class="p_desc_warp">
			                           <span>￥<?php echo number_format(empty($brand->distribution_price) ? $brand->distribution_price : $brand->distribution_price,1);?></span>
			                           <!-- <a href="/product_detail?type=<?php echo $type; ?>&pid=<?php echo $brand->product_id;?>" pitem="<?php echo $brand->product_id;?>" onclick="preShow(this)" curpage="1">立即购买</a> -->
			                        </div>
								</div>
							</li>
						<?php } ?>
		        	</ul>
				</div>
				<div id="page-bot"></div>
				<div class='clear'></div>
		    </div>
		<?php } ?>
		<div id="progressIndicator" style="width:320px;text-align: center; display: none;">
			<img width="85" height="85" src="images/ajax-loader-85.gif" alt="">
			<span id="scrollStats" style="font-size: 70%; width: 80px; text-align: center; position: absolute; bottom: 25px; left: 2px;"></span>
		</div>
	</div>

	<?php include "footer_web.php"; ?>

<script language="javascript">
    var pageInfo  	= {"page":1,"showproid":0,"propage":1,"scrolltop":0};
    var page      	= <?php echo (isset($_SESSION["page"]) && ($_SESSION["page"] > 0) ) ? $_SESSION["page"] : 1; ?>;
    var gPageInfo 	= getLocalInfo();
    var img_loading = true;					// 是否允许继续加载
    var is_loading  = false;

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

    function show(persize)
    {
		var setSize;
        $("#progressIndicator").show();
        if(typeof(persize) != "undefined")
        {
            setSize = true;
        }
        else
        {
            setSize = false;
        }

		if ( ! is_loading )
    	{
    		is_loading = true;

			$.ajax({
				type:'get',
				url: "/product?act=api&func=<?php echo $act; ?>&pid=<?php echo $types;?>&p="+(parseInt(pageInfo.page)+1),
	            dataType: "json",
	            success:function(data){
					$("#progressIndicator").hide();

	            	if(data.code == 0)
					{
						img_loading = false;
					}
					else
					{
						var html = '';
						$.each( data.data,function(k,v){
							html += '<li><div class="product_block_main">';
							html += '<a class="p_img_warp" href="/product_detail?product_id='+ v.id +'" pitem="' + v.id + '" onclick="preShow(this)" curpage="1">';
							html += '<div class="square_img"><img class="lazyload" src="'+ v.image +'" /></div>';
							html += '<p>'+ v.product_name + '</p>';
							html += '</a>';
							html += '<div class="p_desc_warp">';
							html += '<span>￥'+ v.distribution_price + '</span>';
							html += '<a href="/product_detail?product_id='+ v.id +'" pitem="' + v.id + '" onclick="preShow(this)" curpage="1">立即购买</a>';
							html += '</div>';
							html += '</div></li>';


							// html += '<a href="/product_detail?product_id='+ v.id +'" pitem="' + v.id + '" onclick="preShow(this)" curpage="1">';
							// html += 		'<dd>';
							// html += 			'<div class="p_img_warp">';
							// html += 				'<img class="lazyload" src="'+ v.image +'" />';
							// html += 			'</div>';
							// html += 			'<div class="p_desc_warp">';
							// html += 				'<p>'+ v.product_name + '</p>';
							// html += 				'<p>￥'+ v.distribution_price + '</p>';
							// html += 			'</div>';
							// html += 		'</dd>';
							// html += 	'</a>';
						} )

						$('#initRender>ul').append(html);
						pageInfo.page++;
		                pageInfo.showproid = 0;
		                if(setSize) pageInfo.page = gPageInfo.propage;
		                if(gPageInfo.scrolltop > 0) $(document).scrollTop(gPageInfo.scrolltop);
		                is_loading = false;
					}


	            }
			})
    	}

    }

    $(window).scroll(function () {
    	if ( img_loading === true )
    	{
    		var scrollTop = $(this).scrollTop();
	        var scrollHeight = $(document).height();
	        var windowHeight = $(this).height();
	        if (scrollTop + windowHeight == scrollHeight)
	        {
				show();
	        }
    	}
    });
</script>

</body>
</html>
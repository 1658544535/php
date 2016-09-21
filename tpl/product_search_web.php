<!doctype html>
<html lang="zh">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1, user-scalable=no" />
<title><?php echo $site_name;?></title>
<link href="/css/common.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="/js/jquery-1.11.0.min.js"></script>
<script src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>
<script type="text/javascript" src="/js/wxshare.js"></script>
<script>
	wxshare( <?php echo WXJSDEBUG;?>, '<?php echo WXJSAPPID;?>', <?php echo WXJSTIMESTAMP;?>, '<?php echo WXJSNONCESTR;?>', '<?php echo WXJSSIGNATURE;?>', '<?php echo WEBLOGO;?>', '<?php echo $SHARP_URL;?>', '<?php echo WEBTITLE;?>', '<?php echo WEBDESC;?>' )
</script>
<script type="text/javascript">

var page 	= <?php echo (isset($_SESSION["page"]) && ($_SESSION["page"] > 0) ) ? $_SESSION["page"] : 1; ?>;
var allpage = <?php echo $productList['PageCount']; ?>;

function show()
{
	if( page < allpage )
	{
        $("#progressIndicator").show();
        page++;
        $.get("ajaxtpl/ajax_product_new.php?category_id=<?php echo $type;?>&key=<?php echo $key;?>&page="+page,
        function(data)
        {
            $("#page" + page).after(data);
            $("#progressIndicator").hide();
        })
    }
    else
    {
    	alert('已经到达底部！');
    	$("#load_btn").hide();
    }
}

</script>
</head>

<body>

<div id="header">
	<form action="product_search" method="post">
		<input type="hidden" name="act" value="result" />
		<a href="javascript:history.go(-1);" class="header_back"></a>
		<div class="header_search active">
			<div class="header_search_main">
				<input type="search" name="key" placeholder="搜索商品" value="<?php echo $key; ?>" />
			</div>
		</div>
		<a href="javascript:;" class="header_search_close">取消</a>
	</form>
</div>


<div class="pro_list_sort">
	<a href="#" class="on">新品</a>
	<a href="#" class="">价格<i></i></a>
	<a href="#" class="up">销量<i></i></a>
	<a href="#" class="down">人气<i></i></a>
</div>


<div class="nr_warp">
<?php if ( $shoptList == null && $productList['DataSet'] == null ){ ?>
	<div class="order_empty" >
		<dl>
			<dd><img src="/images/order/orderlist_icon.png" width="100" /></dd>
			<dd>无法查找到“<?php echo $key; ?>”的记录</dd>
		</dl>
	</div>
<?php }else{ ?>
	<!--<?php if($shoptList != null){ ?>
		<div class="product_block_warp">
		    <dl class="shop_warp">
		    	<dt style='padding:10px 5px; margin:0px 0 10px 0; border-bottom:1px dashed #e3e3e3;'>
		    		<strong>查找到的店铺：</strong>
		    	</dt>
		        <?php
		            foreach($shoptList as $shop)
		            {
		            	$main_category = preg_split( '#:#', $shop->main_category );
						$main_category=$db->get_var("select name from sys_dict where type ='main_category' and value='".$main_category[1]."' ");
		        ?>

		            <a href="/shop_detail?id=<?php echo $shop->id;?>">
		               <dd>
		                    <div class="p_img_warp">
		                        <img src="<?php echo $site_image?>/shop/<?php echo $shop->images;?>" alt="" />
		                    </div>

		                    <div class="p_desc_warp">
		                        <p>主营：<?php echo $main_category; ?></p>
		                        <p>地址：<?php echo $shop->address; ?></p>
		                        <p><?php echo mb_substr($shop->name, 0 , 20 ,'utf-8'); ?></p>
		                    </div>
		              </dd>
		            </a>
		        <?php } ?>
		        <div class='clear'></div>
		    </dl>
		</div>
	<?php } ?>-->

	<?php if($productList['DataSet'] != null){ ?>
		<div class="product_block_warp">
	        <ul>
	            <?php foreach($productList['DataSet'] as $product){ ?>
                   	<li>
                        <div class="product_block_main">
                        	<a class="p_img_warp" href="product_detail?product_id=<?php echo $product->id;?>">
	                            <div class="square_img"><img src="<?php echo $site_image?>/product/small/<?php echo $product->image;?>" alt="" /></div>
	                            <p><?php echo $product->product_name; ?></p>
	                        </a>

	                        <div class="p_desc_warp">
	                           <span>￥<?php echo $product->distribution_price;?></span>
	                           <a href="product_detail?product_id=<?php echo $product->id;?>">立即购买</a>
	                        </div>
                        </div>
                  	</li>
	            <?php } ?>
	            <div id="page2" name="page2"></div>
	            <div class='clear'></div>
	        </ul>

	   		<div id="load_btn" style="cursor:pointer; height:40px; line-height:40px; width:100%; text-align:center" onclick="show();"  >点击加载</div>

		   	<div id="progressIndicator" style="width:320px;text-align: center; display: none;">
		        <img width="85" height="85" src="images/ajax-loader-85.gif" alt="">
		        <span id="scrollStats" style="font-size: 70%; width: 80px; text-align: center; position: absolute; bottom: 25px; left: 2px;"></span>
		    </div>
		</div>
	<?php } ?>
<?php } ?>

<?php include "footer_web.php"; ?>

</body>
</html>
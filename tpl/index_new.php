<!doctype html>
<html lang="zh">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1, user-scalable=no" />
        <meta content="telephone=no" name="format-detection" />
        <title><?php echo $site_name;?></title>
        <link href="css/common.css" rel="stylesheet" type="text/css" />
        <link href="css/index-new.css" rel="stylesheet" type="text/css" />
        <link rel="stylesheet" href="css/swiper.min.css">
        <script type="text/javascript" src="js/jquery-1.11.0.min.js"></script>
        <script src="js/swiper.min.js"></script>
    </head>
    <body>

    	<div id="header" class="header-index">
    	    <a href="class.php" class="header-icon header-search header-left"></a>
    	    <p class="header_title"><img src="images/logo.png" /></p>
    	    <a href="cart.php" class="header-icon header-cart header-right"></a>
    	</div>

    	<div class="swiper-container index-banner">
            <div class="swiper-wrapper">
              <?php foreach ($objBannerImages as $banner) { ?>                
                <div class="swiper-slide">
					<?php
					switch($banner->param_type){
						case 1:
							$_href = 'product_detail?type=3&pid='.$banner->param_id;
							break;
						case 2:
							$_href = 'special_detail.php?aid='.$banner->param_id;
							break;
						case 7:
							$_href = 'weipage.php?id='.$banner->param_id;
							break;
						case 8:
							$_href = $banner->link;
							break;
						default:
							$_href = '#';
							break;
					}
					?>
					<a href="<?php echo $_href;?>">
                      <img src="<?php echo $site_image?>focusbanner/<?php echo $banner->banner; ?>" />
					</a>
                </div>
              <?php } ?>
            </div>
            <!-- Add Pagination -->
            <div class="swiper-pagination"></div>
        </div>

        <div class="index-class">
        	<ul>
                <?php foreach ($objProductType as $type) {
                  if($type->id !=''){
                	?>
        		<li>
                    <a href="/product?act=lists&pid=<?php echo $type->id; ?>">
                        <div><img src="<?php echo $site_image ;?>productType/<?php echo $type->image; ?>" /></div>
                        <p><?php echo $type->name ;?></p>
                    </a>
                </li>
        		<?php }}?>
        		<li>
                    <a href="product_class.php?act=type">
                        <div><img src="images/index-class-more.png" /></div>
                        <p>更多分类</p>
                    </a>
                </li>
            </ul>
        </div>

        <div class="index-brand">
        	<h3 class="title">- 热门品牌 -</h3>
        	<ul>
        		<?php foreach ($objBrandDic as $hot) {?>                 
                <li><a href="/product?act=brand&bid=<?php echo $hot->brand_id; ?>"><img src="<?php echo $site_image?>businessCenter/brandDic/<?php echo $hot->logo;?> " onerror="this.onerror=null;this.src='http://weixinstorenew/res/images/default_big.png'" /></a></li>
        		<?php }?>
        	</ul>
        </div>

        <div class="index-goods" data-loading="0" data-loadending="0" data-type="1" data-page="1">
        	<div class="tab-title">
        		<div class="active" data-type="1">每日上新</div>
        		<div data-type="2">销售排行</div>
        	</div>
        	<ul class="tab-main" id="goodsTab">
        	  <?php foreach ($objProduct['DataSet'] as $pro) {?>
        		<li>
                    <a href="product_detail?type=3&pid=<?php echo $pro->id;?>">
            		  <div class="img"><img src="<?php echo $site_image?>product/small/<?php echo $pro->image ;?>" /></div>
            			<div class="info">
            				<div class="title"><?php echo $pro->product_name ;?></div>
            				<div class="tips"><?php echo $pro->product_sketch ;?></div>
            				<div class="oldPrice"><span>¥</span><?php echo $pro->sell_price;?></div>
            				<div class="price"><span>¥</span><?php echo $pro->active_price;?></div>
            			</div>
            		</a>
                </li>
              <?php }?>
            </ul>
            <div class="loading"></div>
        </div>

        <?php include "footer_menu_web_tmp.php";?>

        <script type="text/javascript">
            var goodAjax = null;
        	$(function(){
        		var swiper = new Swiper('.index-banner', {
        	        pagination: '.index-banner .swiper-pagination',
        	        paginationClickable: true,
        	        // autoHeight: true, //enable auto height
        	    });

                $(".index-goods .tab-title div").bind("click", function(){
                    $(".index-goods .tab-title div").removeClass("active");
                    $(this).addClass("active");
                    var type = $(this).attr("data-type");
                    getGoodsHtml(".index-goods", type, 1);
                });

                getGoodsHtml(".index-goods", 1, 1);

                //滚动到底部加载更多
                $(window).scroll(function(){
                    show(".index-goods");
                });
        	});

            function show(id){
                var wHeight = parseInt($(window).height());
                var dHeight = parseInt($(document).height());
                var tScroll = parseInt($(document).scrollTop());
                var loading = parseInt($(id).attr("data-loading"));
                var loadending = parseInt($(id).attr("data-loadending"));
                
                if(!loading && !loadending && (tScroll >= dHeight-wHeight)){
                    $(id).attr("data-loading", 1);
                    var type = $(id).attr("data-type"),
                        page = parseInt($(id).attr("data-page"));
                    getGoodsHtml(id, type, page);
                }
            };

            function getGoodsHtml(id, type, page){
                $(".index-goods").find(".loading").show();
                if(!!goodAjax){
                    goodAjax.abort();
                }
                goodAjax = $.ajax({
                    url: "/ajaxtpl/ajax_index_new.php",
                    data: {
                        page: page,
                        type: type
                    },
                    success: function(data){
                        $(".index-goods").attr("data-loading", 0).find(".loading").hide();
                        if(page == 1){
                            $("#goodsTab").html(data);
                            $(".index-goods").attr({"data-page":"2", "data-type":type});
                        }else{
                            $("#goodsTab").append(data);
                            $(".index-goods").attr({"data-page":page+1, "data-type":type});
                        }
                        var recordCount = $("input[name='recordCount']").val();
                        if(page >= recordCount){
                        	$(id).attr("data-loadending",1);
                        }
                    }
                });
            }
        </script>

    </body>
</html>

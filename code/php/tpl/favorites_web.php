<?php
/*
<!doctype html>
<html lang="zh">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1, user-scalable=no" />
<title><?php echo $site_name;?></title>
<link href="/css/common.css" rel="stylesheet" type="text/css" />
<style>
	.p_desc_warp{margin:10px 5px;padding:0;text-align:center;}
</style>
<script type="text/javascript" src="/js/jquery-1.11.0.min.js"></script>
<script src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>
<script type="text/javascript" src="/js/wxshare.js"></script>
<script>
	wxshare( <?php echo WXJSDEBUG;?>, '<?php echo WXJSAPPID;?>', <?php echo WXJSTIMESTAMP;?>, '<?php echo WXJSNONCESTR;?>', '<?php echo WXJSSIGNATURE;?>', '<?php echo WEBLOGO;?>', '<?php echo $SHARP_URL;?>', '<?php echo WEBTITLE;?>', '<?php echo WEBDESC;?>' )
</script>
<script type="text/javascript">
	function buy_now(product_id)
	{
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

	function replace(favorid)
	{
		if(confirm("确定要取消该收藏吗?"))
		{
			$.ajax({
				url:'user_info?act=product_collect_del&id='+favorid,
				type:'POST',
				dataType: 'json',
				error: function(){
	     			fadeInTips('请求超时，请重新添加');
	    		},
	    		success: function(result){
	    			fadeInTips(result.msg);
	    			if ( result.code > 0 )
	    			{
	    				location.href = '/user_info?act=product_collect&return_url=<?php echo $return_url; ?>';
	    			}
	    		}
			});
		}
		return false;
	}

	function fadeInTips(txt)
	{
		var ahtml = '<div class="fadeInTips">' + txt + '</div>';
		if($(".fadeInTips").length<=0)
		{
			$("body").append(ahtml);
		}
		else
		{
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
    <a href="javascript:history.go(-1);" class="header_back"></a>
    <p class="header_title">商品收藏</p>
<!--     <a id="fav_del" href="javascript:;" class="header_txtBtn hide">删除</a> -->
<!--     <a id="fav_edit" href="javascript:;" class="header_txtBtn">编辑</a> -->
</div>

<div class="nr_warp">

<?php if( $arrFavoriteList!= null ){ ?>
	<div class="product_block_warp">
        <ul>
		    <?php foreach($arrFavoriteList as $fav){ 
	
		    	?>
	           	<li><a class="p_img_warp" href="product_detail?type=<?php echo $fav['type'];?>&pid=<?php echo $fav['product_id'];?>&aid=<?php echo $fav['activity_id']?>">
	                <div class="product_block_main">
	                	<div class="list_checkbox hide"><input type="checkbox" /></div>
	                	
                        <div class="square_img">
                        	<img src="<?php echo $site_image?>product/small/<?php echo $fav['image'];?>" alt="" />
                        </div>
                        <p><?php echo mb_substr($fav['product_name'], 0 , 20 ,'utf-8');?></p>

	                    <div class="p_desc_warp">
	                       <span>￥<?php echo sprintf('%.1f',$fav['distribution_price']);?></span>
	                       <!-- <a href="product_detail?pid=<?php echo $fav['product_id'];?>">立即购买</a> -->
	                    </div>
						<div class="undercarriage <?php echo ( $fav['enable'] ==0) ? 'show' : 'hide' ?>" onclick='location.href="product_detail?pid=<?php echo $fav['product_id'];?>"'></div>
	                </div>
	            </a></li>

			<?php } ?>
        </ul>
	</div>
<?php }else{ ?>
		<div class="order_empty" >
			<dl>
				<dd><img src="/images/order/orderlist_icon.png" width="100" /></dd>
				<dd>您暂无收藏的商品！</dd>
			</dl>
		</div>
	<?php }?>
</div>


<?php include "footer_web.php"; ?>
<script>
	$(function(){
		$("#fav_edit").on("click",function(){
			var _this = $(this);
			if(_this.html() == "编辑"){
				_this.html("完成");
				$("#fav_del,.list_checkbox").removeClass("hide");
			}else{
				_this.html("编辑");
				$("#fav_del,.list_checkbox").addClass("hide");
			}
		});

		$(".list_checkbox input").on("change",function(){
			var _this = $(this);
			if(_this.is(":checked")){
				_this.parents(".list_checkbox").addClass("active");
			}else{
				_this.parents(".list_checkbox").removeClass("active");
			}
		})
	})
</script>
</body>
</html>
*/
?>





<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>淘竹马</title>
    <meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, minimal-ui, user-scalable=0" name="viewport">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <link rel="stylesheet" href="css/sm.min.css">
    <link rel="stylesheet" href="css/all.min.css">
    <link rel="stylesheet" href="js/swiper/swiper.min.css">
    <script type='text/javascript' src='js/zepto.js' charset='utf-8'></script>
    <script type='text/javascript' src='js/baiduTemplate.js' charset='utf-8'></script>
    <script type='text/javascript' src='js/sui/sm.min.js' charset='utf-8'></script>
    <script type='text/javascript' src='js/swiper/swiper.min.js' charset='utf-8'></script>
    <script type='text/javascript' src='js/app.min.js' charset='utf-8'></script>
</head>

<body>
    <div class="page-group" id="page-collection">
        <div id="page-nav-bar" class="page page-current">
            <header class="bar bar-nav">
                <a class="button button-link button-nav pull-left back" href="">
                    <span class="icon icon-back"></span>
                </a>
                <h1 class="title">我的收藏</h1>
            </header>

            <div class="content native-scroll">

                <section class="user-collection pullbox infinite-scroll infinite-scroll-bottom" data-distance="30" data-href="">
                    <ul class="list-container"></ul>
                    <!-- 加载提示符 -->
                    <div class="infinite-scroll-preloader">
                        <div class="preloader"></div>
                    </div>
                </section>

            </div>

            <script id='tpl_pull' type="text/template">
                <%for(var i=0;i<data["listData"].length; i++){%>
                    <li>
                        <a href="#" class="img"><img src="" /></a>
                        <div class="info">
                            <a href="#" class="name">优彼思维训练机优比早教机学习机逻辑故事平板电脑幼儿童点读机</a>
                            <div class="option">
                                <a href="#" class="group">
                                    2人团&nbsp;&nbsp;<font class="themeColor">￥<span class="price">49.9</span></font>
                                    <span class="btn">去开团&nbsp;&gt;</span>
                                </a>
                                <a href="javascript:;" class="collecting"></a>
                            </div>
                        </div>
                    </li>
                <%}%>
            </script>

        </div>
    </div>
</body>

</html>

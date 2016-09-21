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

<!doctype html>
<html lang="zh">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1, user-scalable=no" />
<title><?php echo $site_name;?></title>
<link href="css/index4.css" rel="stylesheet" type="text/css" />
<link href="/css/common.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="/js/jquery-1.11.0.min.js"></script>
<script type="text/javascript" src="js/jquery.cycle.all.js"></script>
<script src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>
<script type="text/javascript" src="/js/wxshare.js"></script>
<style type="text/css">
	.notsell .p_img_warp img{-moz-opacity:0.2;opacity:0.2;}
	.notsell .p_desc_warp{color:#ccc}
</style>
<script>
	wxshare( <?php echo WXJSDEBUG;?>, '<?php echo WXJSAPPID;?>', <?php echo WXJSTIMESTAMP;?>, '<?php echo WXJSNONCESTR;?>', '<?php echo WXJSSIGNATURE;?>', '<?php echo WEBLOGO;?>', '<?php echo $SHARP_URL;?>', '<?php echo WEBTITLE;?>', '<?php echo WEBDESC;?>' )
</script>
<script type="text/javascript">
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

function replace(favorid){
	if(confirm("确定要删除该专场吗?"))
	{
		$.ajax({
			url:'user_info?act=special_collect_del&id='+favorid,
			type:'POST',
			dataType: 'json',
			error: function(){
     			alert('请求超时，请重新添加');
    		},
    		success: function(result){
    			fadeInTips( result.msg );
    			if ( result.code > 0 )
    			{
    				location.href = '/user_info?act=special_collect&return_url=<?php echo $return_url; ?>';
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
	    <p class="header_title">专场收藏</p>
<!-- 	    <a id="fav_del" href="javascript:;" class="header_txtBtn hide">删除</a> -->
<!-- 	    <a id="fav_edit" href="javascript:;" class="header_txtBtn">编辑</a> -->
	</div>

	<div class="nr_warp">
		<?php if( $favoriteList!= null ){ ?>
			<div class="scene_list">
				<ul>
					<?php
					foreach($favoriteList as $fav)
					{
					?>
						<li>
							<div class="list_checkbox hide"><input type="checkbox" /></div>
							<a href="special_detail.php?aid=<?php echo $fav->activity_id;?>">
								<div class="scene_img"><img src="<?php echo $site_image?>specialShow/<?php echo $fav->info->banner; ?>" /></div>
								<h3 class="scene_name"><?php echo mb_substr($fav->info->name , 0 , 20 ,'utf-8');?></h3>
								<p class="state">进行中</p>
							</a>
						</li>

					<?php } ?>
				</ul>
			</div>
		<?php }else { ?>
			<div class="order_empty" >
				<dl>
					<dd><img src="/images/order/orderlist_icon.png" width="100" /></dd>
					<dd>您暂无收藏的专场！</dd>
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

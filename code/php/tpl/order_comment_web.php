<!doctype html>
<html lang="zh">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1, user-scalable=no" />
<meta content="telephone=no" name="format-detection" />
<title><?php echo $site_name;?></title>
<link href="/css/common.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="/js/jquery-1.11.0.min.js"></script>
<script src="js/jquery.rateit.js" type="text/javascript"></script>
<script src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>
<script type="text/javascript" src="/js/wxshare.js"></script>
<script>
	wxshare( <?php echo WXJSDEBUG;?>, '<?php echo WXJSAPPID;?>', <?php echo WXJSTIMESTAMP;?>, '<?php echo WXJSNONCESTR;?>', '<?php echo WXJSSIGNATURE;?>', '<?php echo WEBLOGO;?>', '<?php echo $SHARP_URL;?>', '<?php echo WEBTITLE;?>', '<?php echo WEBDESC;?>' )
</script>

</head>

<body>

	<div id="header">
	    <a href="javascript:history.go(-1);" class="header_back"></a>
	    <p class="header_title">订单评价</p>
	</div>

	<form action="/orders" method="post" class="commentWarp" >
		<input type="hidden" name="act" value="comment_add" />
		<input type="hidden" name="oid" value="<?php echo $nOrderID; ?>" />
		<ul class="comment_list">
			<?php foreach($orderDetailList as $orderDetail){ ?>
				<li>
					<div class="comment_pro">
						<img src="<?php echo $site_image?>/product/small/<?php echo $orderDetail['product_image'];?>" alt="" />
						<?php
							$name = $orderDetail['product_name'];
							mb_internal_encoding('utf8');//以utf8编码的页面为例
							//如果内容多余16字
							echo (mb_strlen($name)>30) ? mb_substr($name,0,30).'...' : $name;
						?>
					</div>
					<?php if( $orderDetail['re_status'] == 0 ){ 	//如果没申请退货才允许评论  ?>
						<div class="comment_item">
							描述相符
							<div class="comment_star">
								<input type="hidden" name="ProductScore[<?php echo $orderDetail['product_id']?>]" value="5">
								<div class="comment_star_img"><i class="active"></i><i class="active"></i><i class="active"></i><i class="active"></i><i class="active"></i></div>
							</div>
						</div>
						<textarea name="comment[<?php echo $orderDetail['product_id']?>]" placeholder="说说你和这件小物的故事吧" class="comment_txt" rows="3"></textarea>
					<?php }else{ ?>
						<p>该订单处于退货退款阶段无法参与评价</p>
					<?php } ?>

				</li>
			<?php } ?>
		</ul>
		<div class="comment_item_other">
			<div class="comment_item">
				卖家服务
				<div class="comment_star">
					<input type="hidden" name="ServiceScore" value="5">
					<div class="comment_star_img"><i class="active"></i><i class="active"></i><i class="active"></i><i class="active"></i><i class="active"></i></div>
				</div>
			</div>
			<div class="comment_item">
				物流服务
				<div class="comment_star">
					<input type="hidden" name="EspeedScore" value="5">
					<div class="comment_star_img"><i class="active"></i><i class="active"></i><i class="active"></i><i class="active"></i><i class="active"></i></div>
				</div>
			</div>
		</div>
		<div style="height:40px;"></div>
		<div class="comment_submit">
			<input name="" type="submit" value="提交评价" />
		</div>
	</form>

	<?php include "footer_web.php";?>
	<script>
		$(function(){
			$(".comment_star_img i").on("click",function(){
				var _this = $(this);
				var index = _this.parent().find("i").index(this);
				_this.parent().find("i").each(function(index1, el) {
					if(index1 > index){
						$(el).removeClass("active");
					}else{
						$(el).addClass("active");
					}
				});
				_this.parent().prev("input").val(index+1);
			});
			// limitAlert("该订单处于退货退款阶段无法参与评价")
		})
		function limitAlert(txt){
			var ahtml = '<div class="limitAlert">'+ txt +'</div>';
			$("body").append(ahtml);
			$(".limitAlert").fadeIn(400);
			setTimeout(function(){
				$(".limitAlert").fadeIn(400,function(){
					$(".limitAlert").remove();
				});
			},2000);
		}
	</script>

</body>
</html>

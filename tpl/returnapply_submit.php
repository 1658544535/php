<html xmlns="http://www.w3.org/1999/xhtml" lang="zh-CN">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta charset="utf-8" name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" />
<title><?php echo $site_name;?></title>
<link href="css/index4.css" rel="stylesheet" type="text/css" />
<link href="/css/common.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="js/jquery-1.4.2.min.js"></script>
<script type="text/javascript" src="js/jquery.cycle.all.js"></script>
<script src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>
<script type="text/javascript" src="/js/wxshare.js"></script>
<script>
	wxshare( <?php echo WXJSDEBUG;?>, '<?php echo WXJSAPPID;?>', <?php echo WXJSTIMESTAMP;?>, '<?php echo WXJSNONCESTR;?>', '<?php echo WXJSSIGNATURE;?>', '<?php echo WEBLOGO;?>', '<?php echo $SHARP_URL;?>', '<?php echo WEBTITLE;?>', '<?php echo WEBDESC;?>' )
</script>
<style>
	.index-wrapper{
		padding:20px auto;
		background:#FFF;
	 }

	.returnLine{
		font-size:13px;
		color:#727272;
		padding:20px 10px;
		line-height:20px;
		height:20px;
		width:90%;
	}

	.returnLine strong{
		display:block;
		width:80px;
		float:left;
		line-height:30px;
	}

	.addressLine{
		font-size:13px;
		color:#727272;
		padding:10px 10px 0;
		width:90%;
		line-height:20px;
	}

	.new_address_warp{ display:none; }

	.address_info{ margin-bottom:15px; }
	.address_info li{ height:28px; }
	.address_info li .left,.address_info li .right p{font-size:14px;}
	.address_info li .left{ width:90px; }
</style>

<script>
	$(function(){
		$('.addressType').change(function(){
			var type = $(this).val();

			if( type == 1 )
			{
				$('.old_address_warp').show();
				$('.new_address_warp').hide();
			}
			else
			{
				$('.new_address_warp').show();
				$('.old_address_warp').hide();
			}
		})
	})

</script>
</head>

<body>
<div id="header">
	<dl id="title_warp">
		<dd>
			<a href="javascript:window.history.back(-1);">
				<img src="/images/index/icon-back.png" />
			</a>
		</dd>
		<dd>提交物流</dd>
	</dl>
</div>

<div class="nr_warp">
	<form action="returnapply" method="post" onsubmit="return tgSubmit()">
		<input type="hidden" name="act" value="submit" />
		<input type="hidden" name="order_id" value="<?php echo $obj->id;?>" />
		<input type="hidden" name="address" value="<?php echo $order_info->user_address_id;?>" />
		<div class="auth-msg-warning">　退货审核成功！请填写退货信息</div>
		<div class="addressWarp">

			<ul class="address_info">
				<h2 style="height:40px; line-height:40px;">退货地址信息</h2>
				<li>
					<div class="left">收货人：</div>
					<div class="right">
						<p>淘竹马售后组</p>
					</div>
				</li>

				<li>
					<div class="left">联系电话：</div>
					<div class="right">
						<p>0754-88098777</p>
					</div>
				</li>

				<li>
					<div class="left">退货地址：</div>
					<div class="right">
						<p>广东省汕头市澄海区莱美路宇博电子商务园4楼群宇互动科技有限公司</p>
					</div>
				</li>
			</ul>

			<div class='product_line_warp'>
				<h2 style="height:40px; line-height:40px;">订单信息</h2>
				<div class='product_line_warp'>

					<a href="/orders_info?order_id=<?php echo $order->id; ?>" onclick="preShow(<?php echo $order->id;?>)">
						<dd>
							<div class="p_img_warp">
								<img src="<?php echo $site_image?>/product/small/<?php echo $user_order_refund->images;?>" alt="" width="80" />
							</div>
							<div class="p_desc_warp">
								<p>
									<?php
										$name = $user_order_refund->product_name;
										mb_internal_encoding('utf8');//以utf8编码的页面为例
										//如果内容多余16字
										echo (mb_strlen($name)>16) ? mb_substr($name,0,16).'...' : $name;
									?>
								</p>
								<p>
									￥<?php echo number_format($user_order_refund->stock_price,1);?> * <?php echo $user_order_refund->refund_num;?>
								</p>
							</div>
							<div class="clear"></div>
						</dd>
					</a>
				</div>
			</div>

			<ul style="margin-top:40px;">
				<li>
					<div class="left">物流公司</div>
					<div class="right">
						<select id="num" name="logType" class="input">
							<?php foreach($logisticsList as $logistics){?>
								<option value="<?php echo $logistics->name_en;?>"><?php echo $logistics->name;?></option>
							<?php	}?>
				    	</select>
					</div>
				</li>

				<li>
					<div class="left">运单号</div>
					<div class="right">
						<input type="text" id="logistics" class="input" name="logistics" />
					</div>
				</li>
			</ul>

			<div class="btn_warp">
				<input type="submit" value="提　交" class="red_btn btn btn_warp" />
			</div>

		</div>
	</form>
</div>
</br></br>
<?php include "footer_web.php";?>

<script type="text/javascript">
	function tgSubmit(){
		var logistics=$("#logistics").val();
		if($.trim(logistics) == ""){
			alert('请输入运单号！');
			return false;
		}
		return true;
	}
</script>

</body>
</html>

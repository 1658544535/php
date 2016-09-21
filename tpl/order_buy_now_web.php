<html xmlns="http://www.w3.org/1999/xhtml" lang="zh-CN">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta charset="utf-8" name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" />
	<meta content="telephone=no" name="format-detection" />
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
	<style type='text/css'>
	        .label_radio {
	            border:#e6e6e6 2px solid;margin: 5px 5px 15px 5px;padding:10px;background-color: #FFF;line-height: 15px;
	        }
	        .label_radio1 {
	            border:#F00 2px solid;margin: 5px 5px 15px 5px;padding:10px;background-color: #FFF;line-height: 15px;color:#f00;
	        }
	</style>

	<script type="text/javascript">

        $(function(){
        	change(<?php echo $get_address->province; ?>, 0);

        	 $("#consigneeType").change(function(){
				 var cpnNo = $("#coupon").val();
				if ($(this).val() == 1)
				{
					$(".confirmOrder-Receipt").show();
					$(".consigneeType").show();
					change(<?php echo $get_address->province; ?>, cpnNo);
				}
				else
				{
					$(".confirmOrder-Receipt").hide();
					$(".consigneeType").hide();
					change(0, cpnNo);
					$.ajax({
				        url: "/address?act=commit2&aid=0&cid=<?php if(isset($cart_ids) && $cart_ids) echo $cart_ids; ?>" ,
				        dataType: "text",
				        success: function(data){
				        	$('#all_price').text(  parseFloat(data).toFixed(1));
						}
					});

				}
			 });

			$("#coupon").bind("change", function(){
				var cpnNo = $(this).val();
				var aid = ($("#consigneeType").val() == 1) ? <?php echo $get_address->province; ?> : 0;
				change(aid, cpnNo);
			});
        });

	    function setupLabel(){
	        if($('.label_radio input').length) {
	            $('.label_radio').each(function(){
	                $(this).removeClass('r_on');
	            });
	            $('.label_radio input:checked').each(function(){
	                $(this).parent('label').addClass('r_on');
	            });
	        };
	    }

		function change(aid, cpnno)
		{
			$.ajax({
		        url: "/address?act=commit2&aid=" + aid + "&pid=<?php echo $_GET['pid'] ?>" + "&num=<?php echo $_GET['num'] ?>&cno="+cpnno ,
		        dataType: "json",
		        success: function(data){
		        	$('.all_price').text(  parseFloat(data.allprice).toFixed(1));
					if((typeof(data.errmsg) != "undefined") && (data.errmsg != "")) alert(data.errmsg);
				}
			});
		}
	</script>
</head>

<body>

	<div class="list-nav">
		<a href="javascript:window.history.back(-1);" class="back"></a>
	    <div class="member-nav-M">确认订单信息</div>
	</div>

	<form action="address" method="post"   onsubmit="return tgSubmit()" >

		<input type="hidden" name="act" value="post2" />
		<input type="hidden" name="product_id" value="<?php echo $_GET['pid']?>" />
		<input type="hidden" name="buy_num" value="<?php echo $_GET['num']?>" />
		<input type="hidden" name="userid" value="<?php echo $userid;?>" />
		<input type="hidden" name="addressId" id="shipping_address_0" value="<?php echo $get_address->id;?>">

		<div class="index-wrapper">
			<div class="confirmOrder-Receipt">
				<a href="/address?act=choose&pid=<?php echo $_GET['pid'] ?>&num=<?php echo $_GET['num'];?>&addressId=<?php echo $get_address->id;?>" style="color:#333;">
						<?php if( $get_address == null ){  // 如果用户地址为空，则显示添加  ?>
							<a href="address_add?cart_ids=<?php echo $cart_ids;?>&pin_type=<?php echo $pin_type;?>&act=add" style="color:#fdc005; margin-top:14px; font-size:14px; text-align:right; padding-right:20px; height:20px; ">点击添加地址信息</a>
						<?php }else{
								$province 	= $db->get_var("select name from sys_area  where id = '".$get_address->province."' ");
								$city		= $db->get_var("select name from sys_area  where id = '".$get_address->city."' ");
								$area		= $db->get_var("select name from sys_area  where id = '".$get_address->area."' ");

								$alladdress			= "<div style='font-size:14px; line-height:30px; height:30px;'><strong>收货人：</strong>".$get_address->consignee."　　".$get_address->consignee_phone."</div>";
								if( $province == $city )
								{
									$alladdress 		 .= "<div style='font-size:12px; margin-bottom:10px; line-height:18px;'><strong>收货地址：</strong>" . $province." ". $area." ". $get_address->address . "</div>";
								}
								else
								{
									$alladdress 		 .= "<div style='font-size:12px; margin-bottom:10px; line-height:18px;'><strong>收货地址：</strong>" . $province." ". $city." ". $area." ". $get_address->address . "</div>";
								}

								echo $alladdress;
						?>
							<p style="color:#000; margin-top:14px; font-size:12px; text-align:right; padding-right:20px; height:20px; ">点击更换地址</p>
						<?php } ?>

				</a>
			</div>

			<?php if( $product_info ){?>
					<div class="shopping_Cart" style="background:#fff; border-top:1px solid #e3e3e3;" >
						<div class="shopping_Cart-title" style="height:50px; border:none; margin-bottom:10px; border-bottom:1px solid #e3e3e3; display:none;">
							配送方式
							<select id="consigneeType" name="consigneeType" style="margin:10px 20px; padding:5px 20px;">
								<option value="1">快递</option>
								<option value="2">自提</option>
							</select>
						</div>

						<div class="shopping_Cart-title" style="height:50px; border:none; margin-bottom:10px; border-bottom:1px solid #e3e3e3;">
							支付方式
							<select id="payMethod" name="payMethod" style="margin:10px 20px; padding:5px 20px;">
								<!--<option value="1">支付宝</option>-->
								<option value="2">微信支付</option>
								<option value="3">货到付款</option>
							</select>
						</div>


						<div class="shopping_Cart-title">商品列表</div>
				    		<div class="order_list">
								<?php $allCount=0; $Amount=0; ?>
								<div class="order_list_list">
									<div class="product_img" width="15%">
										<input type="hidden" name="cids" value="806">
										<img src="<?php echo SITE_IMG ?>/product/small/<?php echo $product_info->image; ?>" alt="" width="80" />
									</div>
									<div class="product_name">
										<p>
											<?php
												$name = $product_info->product_name;
												mb_internal_encoding('utf8');//以utf8编码的页面为例
												//如果内容多余20字
												echo (mb_strlen($name)>20) ? mb_substr($name,0,20).'...' : $name;
											?>
										</p>
										<p style="font-size:12px; color:#df434e; margin-top:10px; text-align:right;" >
											¥ <?php echo number_format($price,1) ?> * <?php echo $buy_num; ?>
										</p>
									</div>

									<?php $allCount +=  $buy_num; $Amount +=  $price * $buy_num; ?>
								</div>
								<div class="order_list_msg" style="border-bottom:1px solid #e3e3e3;">
									<input id="buyer_message" name="remark" type="text" value="" class="add-txt-number" placeholder="请填写订单留言" style="margin:8px 0;" />
								</div>

								<div class="shopping_Cart-title" style="height:50px; border:none; margin-bottom:10px; border-bottom:1px solid #e3e3e3;<?php if(empty($cpnList)){ ?>display:none;<?php } ?>">
									代金券
									<select id="coupon" name="coupon" style="margin:10px 20px; padding:5px 20px;">
										<option value="0">无</option>
										<?php foreach($cpnList as $_cpn){ ?>
											<?php if($_cpn->content['om'] <= $Amount){ ?>
												<option value="<?php echo $_cpn->coupon_no;?>"><?php echo $_cpn->name;?></option>
											<?php } ?>
										<?php } ?>
									</select>
								</div>

								<div class="order_buttom" style="text-align:right; padding-right:20px;">
									<strong>合计<strong class="consigneeType">(含运费)</strong>：</strong>
									<span class="shopping_Cart-table-txt08-red02">
										¥ <span class="all_price"><?php echo number_format($Amount,1); ?></span>
									</span>
								</div>

							</div>
				    	</div>
				    </div>
			<?php } ?>
		</div>

		<div class="submit_nav">
			<div style="color:#333; line-height:50px; font-size:12px; padding-left:20px; float:left;">
				<strong>合计<strong class="consigneeType">(含运费)</strong>：</strong>
				<span style="color:#df434e; font-size:14px;">
					¥ <span class="all_price"><?php echo number_format($Amount,1); ?></span>
				</span>
			</div>
			<div class="order_buttom" style="float:right;">
				<input name=""  type="submit" value="确 认" class="add-button-y" />
			</div>
		</div>

	</form>

	</br>
	</br>
	</br>
	</br>
	<?php  include "footer_web.php"; ?>
	</br>
	</br>
	</br>
	</br>
	</br>
	<?php include "footer_menu_web_tmp.php"; ?>

	<script type="text/javascript">
		function isInt(a)
		{
		    var reg = /^(\d{11})$/;
		    return reg.test(a);
		}

		function tgSubmit(){

			var shipping_address_1=$("#shipping_address_0").val();
			if($.trim(shipping_address_1) == ""){
				alert('请先添加新地址');
				return false;
			}
			return true;
		}
	</script>


	</body>
</html>

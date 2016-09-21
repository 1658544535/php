<!doctype html>
<html lang="zh">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1, user-scalable=no" />
<meta content="telephone=no" name="format-detection" />
<title><?php echo $site_name;?></title>
<link href="css/index4.css" rel="stylesheet" type="text/css" />
<link href="/css/common.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="/js/jquery-1.11.0.min.js"></script>
<script type="text/javascript" src="js/jquery.cycle.all.js"></script>
<script src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>
<script type="text/javascript" src="/js/wxshare.js"></script>
<script>
	wxshare( <?php echo WXJSDEBUG;?>, '<?php echo WXJSAPPID;?>', <?php echo WXJSTIMESTAMP;?>, '<?php echo WXJSNONCESTR;?>', '<?php echo WXJSSIGNATURE;?>', '<?php echo WEBLOGO;?>', '<?php echo $SHARP_URL;?>', '<?php echo WEBTITLE;?>', '<?php echo WEBDESC;?>' )
</script>

<script>
	function del(id)
	{
		if(window.confirm('确定删除该地址记录？'))
		{
			location.href='address.php?act=del&id='+id;
		}
	}

	function set_default(id)
	{
		location.href='address.php?act=defaults&aid='+id;
	}


</script>

</head>

<body>

	<div id="header">
	    <a href="javascript:history.go(-1);" class="header_back"></a>
	    <p class="header_title">地址管理</p>
	    <a id="add_del" href="javascript:;" class="header_txtBtn hide">删除</a>
	    <a id="add_edit" href="javascript:;" class="header_txtBtn">编辑</a>
	</div>

	<div class="nr_warp">
		<?php  if (  $addressList == NULL ){ ?>
			<div class="address_empty" >
				<dl>
					<dd><img src="/images/address/empty_icon.png" width="80" /></dd>
					<dd>您还没有设置收货地址哦！</dd>
					<dd>
						<a href="address?act=add">
							<img src="/images/address/btn_icon.png" width="85" />
						</a>
					</dd>
				</dl>
			</div>
		<?php }else{ ?>
			<div class="address_list_warp">
				<dl>
					<?php foreach ( $addressList as $get_address ){  ?>
						<dd>
							<div class="list_checkbox hide"><input type="checkbox" /></div>
							<a href="/address.php?act=edit&from=<?php echo $from; ?>&aids=<?php echo $get_address->id; ?>">
								<?php
									$address_is_default 	  = ($get_address->is_default == 1) ? "<span style='color:#fff; background:#f9c03b; padding:0px 3px; margin-right:5px;font-size:10px;'>默认</span> " : "";
									$alladdress				  = "<div style='font-size:12px; line-height:30px;'>". $address_is_default ."<span style='font-size:14px;color:#666;'>".$get_address->consignee."</span><span style='float:right;'>".$get_address->consignee_phone."</span></div>";
									$alladdress 			 .= "<div style='font-size:12px; margin-bottom:5px;'>" .  $get_address->desc . "</div>";
									echo $alladdress;
								?>
							</a>
						</dd>
					<?php } ?>
				</dl>
              </div>
		<?php } ?>
	</div>

	<?php if(count($addressList) > 0){ ?>
	<div class="add_address_nav">
		<a href="address?act=add&from=<?php echo $from; ?>&return_url=<?php echo $returnUrl; ?>">添加新地址</a>
	</div>
	<?php } ?>

	<?php include "footer_web.php";?>

	<script>
		$(function(){
			$("#add_edit").on("click",function(){
				var _this = $(this);
				if(_this.html() == "编辑"){
					_this.html("完成");
					$("#add_del,.list_checkbox").removeClass("hide");
				}else{
					_this.html("编辑");
					$("#add_del,.list_checkbox").addClass("hide");
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

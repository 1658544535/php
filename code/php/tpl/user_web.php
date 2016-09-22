<!doctype html>
<html lang="zh">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1, user-scalable=no" />
<title>个人中心</title>
<link href="/css/common.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="/js/jquery-1.11.0.min.js"></script>
<script type="text/javascript" src="js/jquery.cycle.all.js"></script>
<script src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>
<script type="text/javascript" src="/js/wxshare.js"></script>
<script>
	wxshare( <?php echo WXJSDEBUG;?>, '<?php echo WXJSAPPID;?>', <?php echo WXJSTIMESTAMP;?>, '<?php echo WXJSNONCESTR;?>', '<?php echo WXJSSIGNATURE;?>', '<?php echo WEBLOGO;?>', '<?php echo $SHARP_URL;?>', '<?php echo WEBTITLE;?>', '<?php echo WEBDESC;?>' )
</script>

<script>
	function unbind()
	{
		if ( confirm("取消绑定后将清空其所有数据，是否确认要取消绑定？") )
		{
			window.location.href="/user_binding?act=unbind";
		}
	}
</script>

</head>
<body>


<div class="user_warp">
	<div class="user_top_warp">
		<a href="/user_info.php">
			<div class="photo">
				<?php if ( ! $bLogin || $user->image == "" ){ ?>
					<img src="images/user/photo.png"/>
				<?php }else{ ?>
					<?php if ( preg_match('#^http://.*#', $user->image) ){ ?>
						<img src="<?php echo $user->image; ?>" style="" />
					<?php }else{ ?>
						<img src="<?php echo $site_image; ?>userlogo/<?php echo $user->image; ?>">
					<?php } ?>
				<?php } ?>
			</div>
			<div class="name">
				<span><?php echo $user->name; ?></span>
				<?php if($objUserInfo->sex ==1){?>
				<img src="../images/user/sex_boy.png" />
				<?php }else{?>
				<img src="../images/user/sex_girl.png" />
			   <?php }?>
			</div>
		</a>
	</div>
	<a href="/user_info.php?act=user_set" class="user_header_set"></a>
	<!-- <div class="user_top_warp">
		<a href="/user_info.php?act=user_set" class="user_set"></a>
		<div class="user_info_warp">
			<div class="user_info_left">
				<a href="/user_info.php" class="btn-avatar">
					<?php if ( ! $bLogin || $user->image == "" ){ ?>
						<img src="images/user/photo.png"/>
					<?php }else{ ?>
						<?php if ( preg_match('#^http://.*#', $user->image) ){ ?>
							<img src="<?php echo $user->image; ?>" style="" />
						<?php }else{ ?>
							<img src="<?php echo $site_image; ?>userlogo/<?php echo $user->image; ?>">
						<?php } ?>
					<?php } ?>
				</a>
			</div>

			<div class="user_info_right">
				<?php if( ! $bLogin ){ ?>
					<dl class="user_btn_warp" style="height:55px;">
						<a href="/user_binding?act=user_bind" class="btn-id btn-login">立即登录</a>
						<a href="/user_binding?act=user_reg" class="btn-id btn-reg">新人注册</a>
					</dl>
				<?php }else{ ?>
					<div class="info-con" style="height:auto; margin-bottom:20px;">
						<div class="info-ide">
							<span class="info-name"><?php echo $user->name; ?></span>
							<span class="info-idicon"><img src="images/user/user_type.png" /></span>
						</div>
						<div class="baby-info">
							<?php if(!$objUserInfo->baby_sex || !$objUserInfo->baby_birthday){ ?>
								宝宝信息还没有完善哦
							<?php }elseif(!empty($babyAge)){ ?>
								宝宝年龄：<?php echo $babyAge;?>
							<?php } ?>
						</div>
					</div>
				<?php } ?>

				<dl class="user_count">
					<dd>
						<a href="/user_info?act=product_collect&return_url=/user">
							<p><?php echo $count_product; ?></p>
							<p>商品收藏</p>
						</a>
					</dd>

					<dd>
						<a href="/user_info?act=special_collect&return_url=/user">
							<p><?php echo $count_special; ?></p>
							<p>专场收藏</p>
						</a>
					</dd>

					<dd>
						<a href="user_info?act=history&return_url=/user">
							<p><?php echo $count_history; ?></p>
							<p>我的足迹</p>
						</a>
					</dd>
				</dl>
			</div>
		</div> -->
	</div>

	<div class="user_block_list">
		<ul>
			<li><a href="orders"><i class="user_icon_order"></i>我的订单</a></li>
			<li><a href="/user_info?act=product_collect&return_url=/user"><i class="user_icon_collect"></i>我的收藏</a></li>
			<li><a href="/user_info.php?act=coupon&return_url=user"><i class="user_icon_coupon"></i>优惠券</a></li>
			<li><a href="user_info?act=history&return_url=/user"><i class="user_icon_history"></i>我的浏览</a></li>
			<li><a href="/address?act=manage"><i class="user_icon_address"></i>地址管理</a></li>
			<li><a href="help"><i class="user_icon_help"></i>客服与帮助</a></li>
		</ul>
	</div>

	<!-- <div class="user_order">
		<div class="user_order_all">
			<a href="orders?return_url=user">我的订单</a>
		</div>
		<ul class="user_order_list">
			<li><a href="orders?sid=1&return_url=user" class="user_order_1">待付款<?php echo $onway_orders1 == 0 ? '' : '<i>'.$onway_orders1.'</i>'; ?></a></li>
			<li><a href="orders?sid=2&return_url=user" class="user_order_2">待发货<?php echo $onway_orders2 == 0 ? '' : '<i>'.$onway_orders2.'</i>'; ?></a></li>
			<li><a href="orders?sid=3&return_url=user" class="user_order_3">待收货<?php echo $onway_orders3 == 0 ? '' : '<i>'.$onway_orders3.'</i>'; ?></a></li>
			<li><a href="orders?sid=4&return_url=user" class="user_order_4">待评价<?php echo $onway_orders4 == 0 ? '' : '<i>'.$onway_orders4.'</i>'; ?></a></li>
			<li><a href="orders?act=return&return_url=user" class="user_order_5">我的售后<?php echo $order_refund_num == 0 ? '' : '<i>'.$order_refund_num.'</i>'; ?></a></li>
		</ul>
	</div> -->

	<!-- <ul class="user_line_list">
		<li><a href="/user_info.php?act=coupon&return_url=user" class="user_wallet">我的钱包</a></li>
		<li><a href="/user_info.php?act=wallet" class="user_wallet">我的钱包</a></li>
		<li><a href="/user_info.php?act=coupon&return_url=user" class="user_vouchers">代金券</a></li>
		<li><a href="/address?act=manage" class="user_addManage">地址管理</a></li>
		<li><a href="help" class="user_help">客服与帮助</a></li>
		<li><a href="/invite.php" class="user_invitation">邀请好友，立即赚钱</a></li>
		<li><a href="/invite.php?act=add" class="user_invitationCode">输入邀请码</a></li>
		<li><a href="javascript:fn_contact('4001503677','4001503677','http://weixinm2c.taozhuma.com');" class="user_contact">联系客服</a></li>
	</ul> -->

</div>

<?php include "footer_web.php";?>
<?php include "footer_menu_web_tmp.php"; ?>
<script>
	function fn_contact(tel,qq,cn){
		//电话，qq号码，域名
		var aHtml = '<div class="m_select" id="m_select">'
                  +    '<div class="m_select_bg" onclick="m_select_close()"></div>'
                  +    '<div class="m_select_main animate_moveUp">'
                  +        '<dl>'
                  +           '<dt>联系客服</dt>'
            	  +           '<a href="tel:'+ tel +'"><dd>拨打客服电话'+ tel +'</dd></a>'
            	  // +           '<a target="_blank" href="http://b.qq.com/webc.htm?new=0&sid='+ qq +'&o='+ cn +'/&q=7"><dd>在线QQ咨询</dd></a>'
           		  +        '</dl>'
                  +        '<a href="javascript:m_select_close();" class="m_select_close">取消</a>'
                  +    '</div>'
                  +'</div>';
        $("body").append(aHtml);
	}
    function m_select_close(){
        $(".m_select_main").removeClass("animate_moveUp").addClass("animate_moveDown");
        setTimeout(function(){
            $("#m_select").remove();
        },200);
    }
</script>
</body>
</html>

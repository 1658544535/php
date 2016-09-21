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
		.data_list_warp a{ color:#666; }
		.data_list_warp dd{ border-bottom:1px solid #e2e2e2; height:50px; }
		.data_list_warp dd div.left{ float:left; width:55%; line-height:50px; padding-left:2%; }
		.data_list_warp dd div.right{ float:right; width:40%; line-height:50px; text-align:right; padding-right:2%; }
		.data_list_warp dd span.time{ color:#c3c3c3; }
	</style>

</head>

<body>
<div id="header">
	<dl id="title_warp">
		<dd>
			<a href="javascript:window.history.back(-1);">
				<img src="/images/index/icon-back.png" />
			</a>
		</dd>
		<dd><?php echo ($type == 1) ? "我的分销订单" : "我的分销商"  ?></dd>
	   <dd><!--<img src="/images/index/icon-back.png" />--></dd>
	</dl>
</div>

<div class="nr_warp">
	<div class="user_distribution_warp">

		<?php if ( $type == 1 ){ ?>
			<?php if( $record_list != null ){   ?>
				<dl class="data_list_warp">
					<?php foreach( $record_list as $record ){ ?>
						<dd>
							<div class="left">
								<p style="line-height:25px;"><?php echo $record->order_no; ?></p>
								<p style="line-height:25px;"><span class="time"><?php echo $record->create_date; ?></span><p>
							</div>
							<div class="right">
								<p style="font-size:14px; font-weight:bold;"><?php echo $record->fact_price; ?></p>
							</div>
							<div class="clear"></div>
						</dd>
					<?php } ?>
				</dl>
			<?php }else{  ?>
				<div class="order_empty" >
				<dl>
					<dd><img src="/images/order/orderlist_icon.png" width="100" /></dd>
					<dd>该用户暂无订单</dd>
				</dl>
			</div>
		<?php }} ?>

		<?php if ( $type == 2 ){ ?>
			<?php if( $record_list != null ){   ?>
				<dl class="data_list_warp">
					<?php foreach( $record_list as $record ){ ?>
						<a href="/user_distribution?act=lists&uid=<?php echo $record->id ?>">
							<dd>
								<div class="left"><?php echo $record->name; ?></div>
								<div class="right"><span class="time"><?php echo $record->create_date; ?></span></div>
								<div class="clear"></div>
							</dd>
						</a>
					<?php } ?>
				</dl>
			<?php } ?>
		<?php } ?>
	</div>

</div>


</br>
</br>
</br>
</br>
</br>
</br>
<?php // include "footer_web.php";?>
</br>
</br>
</br>
<?php include "footer_menu_web_tmp.php"; ?>

<script type="text/javascript">


function isPerson_code(a)
{
    var reg = /^\d{6}(18|19|20)?\d{2}(0[1-9]|1[12])(0[1-9]|[12]\d|3[01])\d{3}(\d|X|x)$/;
    return reg.test(a);
}




function isInt(a)
{
    var reg = /^(\d)+$/;
    return reg.test(a);
}

function tgSubmit(){
	var name=$("#name").val();
	if($.trim(name) == ""){
		alert('请填写姓名');
		return false;
	}


	var person_code=$("#person_code").val();
	if($.trim(person_code) == "" ){
		alert('请填写身份证号码');
		return false;
	}

	if(!isPerson_code(person_code)){
		alert('身份证格式有误！');
		return false;
	}

    var person_code_img=$("#person_code_img").val();
	if($.trim(person_code_img) == ""){
		alert('请上传身份证图片');
		return false;
	}
	return true;
}
</script>

</body>
</html>

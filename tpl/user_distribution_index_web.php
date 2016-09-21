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

	</style>

</head>

<body>
<div id="header">
	<dl id="title_warp">
		<dd>
			<a href="<?php echo $return_url; ?>">
				<img src="/images/index/icon-back.png" />
			</a>
		</dd>
		<dd>我的分销</dd>
	   <dd><!--<img src="/images/index/icon-back.png" />--></dd>
	</dl>
</div>

<div class="nr_warp">
	<div class="user_distribution_warp">
		<div class="user_photo_warp">
			<?php if ( $user->image == "" ){ ?>
				<img src="images/user/photo.png"/>
			<?php }else{ ?>
				<?php if ( preg_match('#^http://.*#', $user->image) ){ ?>
					<img src="<?php echo $user->image; ?>" style=" border-radius:50%; overflow:hidden;" >
				<?php }else{ ?>
					<img src="<?php echo $site_image; ?>userlogo/<?php echo $user->image; ?>" style=" border-radius:50%; overflow:hidden;" >
				<?php } ?>
			<?php } ?>

			<p><?php echo $user->name; ?></p>
		</div>

		<dl class="data_statistics_warp">

			<?php if ( $inviter_count > 0 ){ ?>
				<a href="/user_distribution?act=lists&type=2">
			<?php } ?>
					<dd>
						<p style="color:#9bcb60;"><?php echo $inviter_count; ?></p>
						<p>累计分销者</p>
					</dd>
			<?php if ( $inviter_count > 0 ){ ?>
				</a>
			<?php } ?>

			<?php if ( $inviter_count > 0 ){ ?>
				<a href="/user_distribution?act=lists">
			<?php } ?>
				<dd>
					<p style="color:#ed7980;"><?php echo $order_count; ?></p>
					<p>累计订单数</p>
				</dd>
				<dd>
					<p style="color:#81c0ea;"><?php echo sprintf( '%.1f',$amout_count ); ?></p>
					<p>累计交易额</p>
				</dd>
			<?php if ( $inviter_count > 0 ){ ?>
				</a>
			<?php } ?>
		</dl>
	</div>

</div>


</br>
</br>
</br>
</br>
</br>
</br>
</br>
</br>
</br>
<?php  include "footer_web.php";?>
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

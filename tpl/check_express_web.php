<!doctype html>
<html lang="zh">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1, user-scalable=no" />
<meta name="format-detection" content="telephone=no" />
<title><?php echo $site_name;?></title>
<script type="text/javascript" src="/js/jquery-1.11.0.min.js"></script>
<link href="/css/common.css" rel="stylesheet" type="text/css" />
<script src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>
<script type="text/javascript" src="/js/wxshare.js"></script>
<script>
	wxshare( <?php echo WXJSDEBUG;?>, '<?php echo WXJSAPPID;?>', <?php echo WXJSTIMESTAMP;?>, '<?php echo WXJSNONCESTR;?>', '<?php echo WXJSSIGNATURE;?>', '<?php echo WEBLOGO;?>', '<?php echo $SHARP_URL;?>', '<?php echo WEBTITLE;?>', '<?php echo WEBDESC;?>' )
</script>

</head>

<body>
	<div id="header">
	    <a href="javascript:history.go(-1);" class="header_back"></a>
	    <p class="header_title">物流详情</p>
	</div>

	<div class="ship_info_wrap">
		<img src="<?php echo $site_image .'product/small/'. $product_image; ?>" class="ship_img" />
		<div class="ship_info">
			<div class='top'>
				<p><label>物流状态：</label><span><?php echo $ship_status; ?></span></p>
			</div>
			<p><label>运单编号：</label><?php echo $express_number;?></p>
			<p><label>信息来源：</label><?php echo $ExpressType[$express_type];?></p>
		</div>
	</div>

	<dl class="ship_list">
		<dt>物流跟踪</dt>
		<?php foreach($result['data'] as $key=>$rs){ ?>
			<dd class="<?php echo ($key==0) ? 'active' : '' ?>">
				<p><?php echo $rs['context'];?></p>
				<p><?php echo $rs['time'];?></p>
			</dd>
		<?php } ?>
	</dl>

	<?php include "footer_web.php";?>

</body>
</html>
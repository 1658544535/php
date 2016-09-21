<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="zh-CN">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta charset="utf-8" name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" />
<title><?php echo $site_name;?></title>
<link href="/css/common.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="js/jquery-1.4.2.min.js"></script>
<script src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>
<script type="text/javascript" src="/js/wxshare.js"></script>
<script>
	wxshare( <?php echo WXJSDEBUG;?>, '<?php echo WXJSAPPID;?>', <?php echo WXJSTIMESTAMP;?>, '<?php echo WXJSNONCESTR;?>', '<?php echo WXJSSIGNATURE;?>', '<?php echo WEBLOGO;?>', '<?php echo $SHARP_URL;?>', '<?php echo WEBTITLE;?>', '<?php echo WEBDESC;?>' )
</script>

</head>

<body>

	<div id="header">
		<dl id="title_warp">
			<dd>
				<a href="javascript:window.history.back(-1);" class="back">
					<img src="/images/index/icon-back.png" />
				</a>
			</dd>
			<dd>查找商品</dd>
			<dd><!--<img src="/images/index/icon-back.png" />--></dd>
		</dl>
	</div>

	<div class="nr_warp">
		<form action="product_search" method="post" >
			<div class="bg">
				<input type="hidden" name="act" value="result" />
				<img src='/images/search.png'/>
				<input type="text" name="key" border="0" placeholder="请输入商品名、店铺名"  maxlength="20" />
			</div>
		</form>
<!--
		<dl class="search_key">
			<dt><strong>热门搜索：</strong></dt>
			<?php for( $i=0; $i<10; $i++ ){ ?>
				<dd>遥控汽车</dd>
			<?php } ?>
			<div class="clear"></div>
		<dl>
-->
	</div>

</div>

</br></br></br>
<?php include "footer_web.php"; ?>
</br></br></br>
<?php include "footer_menu_web_tmp.php"; ?>

</body>
</html>

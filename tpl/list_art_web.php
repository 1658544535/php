<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="zh-CN">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta charset="utf-8" name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" />
<title><?php echo $site_name;?></title>

<link href="/css/common.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="js/jquery-1.8.3.min.js"></script>
<script type="text/javascript" src="js/jquery.cycle.all.js"></script>
<script src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>
<script type="text/javascript" src="/js/wxshare.js"></script>
<script>
	wxshare( <?php echo WXJSDEBUG;?>, '<?php echo WXJSAPPID;?>', <?php echo WXJSTIMESTAMP;?>, '<?php echo WXJSNONCESTR;?>', '<?php echo WXJSSIGNATURE;?>', '<?php echo WEBLOGO;?>', '<?php echo $SHARP_URL;?>', '<?php echo WEBTITLE;?>', '<?php echo WEBDESC;?>' )
</script>
	<style>
		body,p{margin:0px; padding:0px; font-family:"Microsoft yahei" !important}
		a{text-decoration: none;}
		.list02-pic-txt{ height:40px; line-height:40px; border-bottom:1px dashed #e3e3e3; }
		.list02-pic-intro-txt{ padding: 10px 12px 30px; border-bottom:1px solid #e3e3e3; }
	</style>
</head>

<body>

	<div id="header">
	<dl id="title_warp">
			<dd>
				<a href="<?php echo $return_url; ?>" class="back">
					<img src="/images/index/icon-back.png" />
				</a>
			 </dd>
			<dd id="text"><?php echo $row->title?></dd>
	   	 <dd><!--<img src="/images/index/icon-back.png" />--></dd>
	   </dl>
	</div>

<div class="nr_warp">
<div class="index-wrapper" style="margin-bottom:40px;">
    <div class="list02-pic-txt" >
    	<p class="list02-pic-txt_01">&nbsp;&nbsp;<?php echo $row->title?></p>
    </div>

	<div class="list02-pic-intro-txt">
    	<?php echo $row->content?>
    </div>
</div>
<?php include "footer_web.php";?>
</br></br></br>
<?php include "footer_menu_web_tmp.php"; ?>
</div>
</body>
</html>

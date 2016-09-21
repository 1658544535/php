<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="zh-CN">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="viewport" content="width=100%;
	    initial-scale=1;
	    maximum-scale=1;
	    minimum-scale=1;
	    user-scalable=no;" />
	<title><?php echo $site_name;?></title>
	<link href="/css/common.css" rel="stylesheet" type="text/css" />
	<script type="text/javascript" src="js/jquery-1.8.3.min.js"></script>
	<script type="text/javascript" src="js/jquery.cycle.all.js"></script>

	<script src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>
	<script type="text/javascript" src="/js/wxshare.js"></script>
	<script>
		link 	= "<?php echo $SHARP_URL ?>";
		title 	= "<?php echo $obj->title;?>";
		wxshare( <?php echo WXJSDEBUG;?>, '<?php echo WXJSAPPID;?>', <?php echo WXJSTIMESTAMP;?>, '<?php echo WXJSNONCESTR;?>', '<?php echo WXJSSIGNATURE;?>', '<?php echo WEBLOGO;?>', link, title, '<?php echo WEBDESC;?>' )
	</script>

	<style>
		body,p{ padding:0; margin:0; font-family:"Microsoft yahei" !important; }
		a{text-decoration: none;}
		.list02-pic-txt { border-bottom:1px dashed #e3e3e3; padding:10px 20px 0; }
		.list02-pic-txt_02 { font-size:12px; color:#df434e; }
		.list02-pic-txt p { margin:10px 0; line-height:20px; }
		.index-wrapper img{ width:95%; margin:5px 0; }
		.content p{ line-height:28px; margin:0 0 5px;  }
	</style>

</head>

<body>
<div class="list-nav">
	<a href="javascript:window.history.back(-1);" class="back"></a>
	<div class="member-nav-M">
		<?php
			$v=$obj->title;  //以$v代表‘长描述’
			mb_internal_encoding('utf8');//以utf8编码的页面为例
			echo (mb_strlen($v)>10) ? mb_substr($v,0,10).'...' : $v //如果内容多余18字

		?>
	</div>
</div>

<div class="index-wrapper">
    <div class="list02-pic-txt" >
    	<p class="list02-pic-txt_01"><?php echo $obj->title; ?></p>
    	<p class="list02-pic-txt_02">作者：<?php echo $obj->author?>&nbsp;&nbsp;时间：<?php echo $obj->create_date; ?></p>
    </div>

    <div class="content" style="padding:15px 20px 20px; border-bottom:1px solid #e3e3e3;">
        <?php echo str_replace("/upfiles","http://www.taozhuma.com/upfiles",$obj->content);?>
    </div>
</div>
<?php include "footer_web.php";?>

</br>
</br>
</br>
</br>
<?php include "footer_menu_web_tmp.php"; ?>
</body>
</html>

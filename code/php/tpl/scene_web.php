<!doctype html>
<html lang="zh">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1, user-scalable=no" />
<title>场景</title>
<link href="/css/common.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="/js/jquery-1.11.0.min.js"></script>
<script src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>
<script type="text/javascript" src="/js/wxshare.js"></script>
<script>
	wxshare( <?php echo WXJSDEBUG;?>, '<?php echo WXJSAPPID;?>', <?php echo WXJSTIMESTAMP;?>, '<?php echo WXJSNONCESTR;?>', '<?php echo WXJSSIGNATURE;?>', '<?php echo WEBLOGO;?>', '<?php echo $SHARP_URL;?>', '<?php echo WEBTITLE;?>', '<?php echo WEBDESC;?>' )
</script>
</head>
<body>

<div id="header">
	<p class="header_title">场景推荐</p>
</div>

<div class="scene_list">
	<ul>
		<?php foreach( $objScene as $Scene ){ ?>
			<li>
				<a href="/scene.php?act=info&sid=<?php echo $Scene->id; ?>">
					<div class="scene_img"><img src="<?php echo $site_image; ?>scene/<?php echo $Scene->image; ?>" /></div>
					<h3 class="scene_name"><?php echo $Scene->name; ?></h3>
					<p class="scene_date"><?php echo $Scene->date_tip; ?></p>
				</a>
			</li>
		<?php } ?>
	</ul>
</div>


<?php include "footer_web.php"; ?>
<?php include "footer_menu_web_tmp.php"; ?>

</body>
</html>

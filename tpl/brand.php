<!doctype html>
<html lang="zh">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1, user-scalable=no" />
		<title>品牌</title>
		<link href="css/common.css" rel="stylesheet" type="text/css" />
		<style>
			#header{position:fixed;top:0;left:0;}
		</style>
	</head>

	<body>

		<div id="header" class="header-class">
			<a href="javascript:history.back(-1);" class="header_back"></a>
			<div class="header_title">
				<a href="product_class.php?act=type">品类</a>
				<a href="product_class.php?act=age">年龄</a>
				<a href="product_class.php?act=brand" class="active">品牌</a>
			</div>
		</div>
		<div style="height:40px;"></div>

		<div class="class-brand">
			<ul>
        		<?php foreach ($BrandList as $brand) {?>
        		 <li><a href="/product?act=brand&bid=<?php echo $brand->id ;?>"><img src="<?php echo $site_image?>businessCenter/brandDic/<?php echo $brand->logo ;?>" onerror="this.onerror=null;this.src='http://weixinstorenew/res/images/default_big.png'"/><p><?php echo $brand->brandName; ?></p></a></li>
        		<?php }?>
        	</ul>
		</div>
	</body>
</html>

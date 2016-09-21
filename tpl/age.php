<!doctype html>
<html lang="zh">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1, user-scalable=no" />
		<title>品类</title>
		<link href="css/common.css" rel="stylesheet" type="text/css" />
		<script type="text/javascript" src="js/jquery-1.11.0.min.js"></script>
		<style>
			#header{position:fixed;top:0;left:0;}
		</style>
	</head>

	<body>

		<div id="header" class="header-class">
			<a href="javascript:history.back(-1);" class="header_back"></a>
			<div class="header_title">
				<a href="product_class.php?act=type">品类</a>
				<a href="product_class.php?act=age" class="active">年龄</a>
				<a href="product_class.php?act=brand">品牌</a>
			</div>
		</div>

		<div class="class-new">
			<ul class="menu">
				  <?php foreach ($ageList as $age){?>
				  <li data-id="<?php echo $age->id ;?>"><?php echo $age->title ;?></li>
				  <?php }?>
			</ul>
			<div class="main">
				<ul>
					<!-- <?php foreach ($TypeList as $type) {?>
						<li><a href="/product?act=lists&type=<?php echo $type->pid; ?>"><img src="<?php echo $site_image?>productType/<?php echo $type->image ;?>" /><p><?php echo $type->name ;?></p></a></li>
					<?php }?> -->
				</ul>
			</div>
		</div>

		<script>
			var ageAjax = null;
			$(function(){
				$(".class-new .menu li").bind("click", function(){
					var _this = $(this);
					$(".main").html('<div class="loading"></div>');
					if(!!ageAjax){
						ageAjax.abort();
					}
					ageAjax = $.ajax({
						url: "/ajaxtpl/ajax_age.php?act=age",
						data: {"id": _this.attr("data-id")},
						success: function(data){
							$(".class-new .menu li").removeClass("active");
							_this.addClass("active");
							$(".main").html(data);
						}
					})
				});
				$(".class-new .menu li").eq(0).trigger("click");
			});
		</script>
	</body>
</html>

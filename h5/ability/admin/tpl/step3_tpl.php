<!doctype html>
<html lang="zh">
<head>
	<meta charset="utf-8">
	<!--IOS中Safari允许全屏浏览-->
	<meta content="yes" name="apple-mobile-web-app-capable">
	<meta content="email=no" name="format-detection" />
	<meta content="telephone=no" name="format-detection">
	<title>你真的了解你的小情人或是小情敌吗</title>
	<link rel="stylesheet" type="text/css" href="../tpl/css/style.css" />
	<script src="../tpl/js/flexible.js"></script>

</head>

<body>
	<div><img src="share_ico.png" style="display:none;" /></div>
    <div class="wrap">
		<section class="test3-ability">
			<?php foreach($fields as $fIndex => $val){ ?>
				<div class="test3-ability-item test3-ability-<?php echo $val['result_style'];?>">
					<div class="test3-ability-chart">
						<div class="test3-ability-img"></div>
						<div class="test-ability-chart">
							<div class="chart"><div style="width:<?php echo $fieldRatio[$fIndex];?>%;"></div></div>
							<div class="txt">
								<b class="percent"><?php echo $fieldRatio[$fIndex];?>%</b>
								<h3 class="title"><?php echo $val['name'];?></h3>
							</div>
						</div>
					</div>
					<div class="test-ability-txt"><?php echo implode('，', $fieldText[$fIndex]).'。';?></div>
				</div>
			<?php } ?>
		</section>

		<section class="test3-goods">
			<h2 class="test3-goods-title">这些玩具可以让宝宝的各项能力更全面</h2>
			<?php foreach($fields as $fIndex => $val){ ?>
				<div class="test3-goods-item test3-goods-<?php echo $val['result_style'];?>">
					<h3 class="itemTitle"><?php echo $val['name'];?></h3>
					<ul class="list">
						<?php foreach($fieldGoods[$fIndex] as $_goods){ ?>
							<li <?php if(!$_goods['sel']) echo 'class="hot"';?>>
								<a >
									<div class="img"><img src="<?php echo $goodsPicUrl.$goodsList[$_goods['goods_id']]['image'];?>" alt=""></div>
									<h4 class="title"><?php echo $goodsList[$_goods['goods_id']]['product_name'];?></h4>
									<p class="tips"><?php echo $val['items'][$_goods['item_index']]['tag'];?></p>
								</a>
							</li>
						<?php } ?>
					</ul>
				</div>
			<?php } ?>
		</section>

	
</body>
</html>

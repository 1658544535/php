<!doctype html>
<html lang="zh">
<head>
	<meta charset="utf-8">
	<!--IOS中Safari允许全屏浏览-->
	<meta content="yes" name="apple-mobile-web-app-capable">
	<meta content="email=no" name="format-detection" />
	<meta content="telephone=no" name="format-detection">
	<meta name="viewport" content="user-scalable=no,width=device-width,initial-scale=1,maximum-scale=1">
	<title>您的宝宝会是下一个“洪荒之力”吗？</title>
	<link rel="stylesheet" type="text/css" href="<?php echo __CURRENT_TPL_URL__;?>/css/style.css" />
	<script src="<?php echo __CURRENT_TPL_URL__;?>/js/flexible.js"></script>
	<?php include_once(CURRENT_TPL_DIR.'share.php'); ?>
</head>

<body>
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
								<a href="<?php echo __CURRENT_ROOT_URL__.'/?act=goods&gid='.$_goods['goods_id'];?>">
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

		<!--<div class="test3-tips">打开淘竹马公众号，在右侧菜单栏”我的竹马”输入暗号<span>我的宝宝是天才</span>，可获赠10元优惠券</div>-->

		<a href="<?php echo __CURRENT_ROOT_URL__;?>/?act=re" class="test3-retest"></a>

		<section class="test3-code">
			<img src="<?php echo __CURRENT_TPL_URL__;?>/images/code.jpg" />
		</section>
    </div>

    <script src="<?php echo __CURRENT_TPL_URL__;?>/js/jquery-2.1.4.min.js"></script>
	<?php include_once(CURRENT_TPL_DIR.'statistics.php'); ?>
</body>
</html>

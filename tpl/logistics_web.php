<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title><?php echo $site_name;?></title>
    <meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, minimal-ui, user-scalable=0" name="viewport">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <link rel="stylesheet" href="css/sm.min.css">
    <link rel="stylesheet" href="css/all.min.css">
    <link rel="stylesheet" href="js/swiper/swiper.min.css">
    <script type='text/javascript' src='js/zepto.js' charset='utf-8'></script>
    <script type='text/javascript' src='js/baiduTemplate.js' charset='utf-8'></script>
    <script type='text/javascript' src='js/sui/sm.min.js' charset='utf-8'></script>
    <script type='text/javascript' src='js/swiper/swiper.min.js' charset='utf-8'></script>
    <script type='text/javascript' src='js/app.min.js' charset='utf-8'></script>
</head>

<body>
    <div class="page-group" id="page-logistics">
        <div id="page-nav-bar" class="page page-current">
            <header class="bar bar-nav">
                <a class="button button-link button-nav pull-left back" href="">
                    <span class="icon icon-back"></span>
                </a>
                <h1 class="title">查看物流</h1>
            </header>

            <div class="content native-scroll">
				<?php if(!$info['success']){ ?>
					<div>网络异常，请稍候再试</div>
				<?php }elseif(empty($info['result'])){ ?>
					<div>没有相关物流信息</div>
				<?php }else{ ?>
					<section class="logistics-header">
						<div class="company">物流公司：<?php echo $info['result']['expressType'];?></div>
						<div class="number">运单编号：<?php echo $info['result']['expressNumber'];?></div>
					</section>
					<section class="logistics-process">
						<h3 class="title1">订单跟踪</h3>
						<ul>
							<?php foreach($info['result']['express'] as $k => $v){ ?>
								<li<?php if($k==0){ ?> class="active"<?php } ?>>
									<div><?php echo $v['content'];?></div>
									<div><?php echo $v['time'];?></div>
								</li>
							<?php } ?>
						</ul>
					</section>
				<?php } ?>
            </div>

			<?php include_once('footer_nav_web.php');?>

        </div>
    </div>
</body>

</html>

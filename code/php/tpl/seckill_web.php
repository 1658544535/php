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
	<?php include_once('wxshare_web.php');?>
</head>

<body>
    <div class="page-group" id="page-seckill">
        <div id="page-nav-bar" class="page page-current">
            <header class="bar bar-nav">
                <a class="button button-link button-nav pull-left back" href="">
                    <span class="icon icon-back"></span>
                </a>
                <a class="button button-link button-nav pull-right share" href="javascript:;">
                    <span class="icon icon-share"></span>
                </a>
                <h1 class="title">掌上秒杀</h1>
            </header>

            <nav class="bar bar-tab">
                <a class="tab-item tab-item2<?php if($type == 1){ ?> active<?php } ?>" href="seckill.php">
                    <span class="icon i-seckill-today"></span>
                    <span class="tab-label">今日秒杀</span>
                </a>
                <a class="tab-item tab-item2<?php if($type == 2){ ?> active<?php } ?>" href="seckill.php?t=2">
                    <span class="icon i-seckill-tomorrow"></span>
                    <span class="tab-label">明日预告</span>
                </a>
                <a class="tab-item tab-item2<?php if($type == 3){ ?> active<?php } ?>" href="seckill.php?t=3">
                    <span class="icon i-seckill-afterTomorrow"></span>
                    <span class="tab-label">后日预告</span>
                </a>
            </nav>

            <div class="content native-scroll">
                <section class="index-seckill">
                    <a href="sellout.php" class="seckill-out">查看今天已售罄商品</a>
					<?php foreach($info as $_info){ ?>
						<h3 class="seckill-title active"><?php echo $_info['time'];?><?php if($_info['isStart']==1){ ?> 正在进行中<?php } ?></h3>
						<ul class="list-container">
							<?php foreach($_info['secKillList'] as $v){ ?>
								<li>
									<a href="groupon.php?id=<?php echo $v['activityId'];?>&pid=<?php echo $v['productId'];?>">
										<div class="img"><img src="<?php echo $v['productImage'];?>" /></div>
										<div class="info">
											<div class="name"><?php echo $v['productName'];?></div>
											<div class="price">
												<span class="price1">￥<?php echo $v['productPrice'];?></span>
												<span class="price2">￥<?php echo $v['alonePrice'];?></span>
												<div class="range">
													<div class="range-main" style="width:<?php echo $v['salePerce'];?>%"></div>
													<div class="num"><?php echo $v['salePerce'];?>%</div>
												</div>
											</div>
											<div class="btn">
												<?php if($v['isSellOut'] == 1){ ?>
													<span class="gray">已售罄</span>
												<?php }elseif($_info['isStart'] == 1){ ?>
													<span class="red">去抢购</span>
												<?php }else{ ?>
													<span class="orange">即将开抢</span>
													<p class="txt orange">限量<?php echo $v['limitNum'];?>件</p>
												<?php } ?>
											</div>
										</div>
									</a>
								</li>
							<?php } ?>
						</ul>
					<?php } ?>


					<?php
					/*
                    <h3 class="seckill-title active">10:00 正在进行中</h3>
                    <ul class="list-container">
                        <li><a href="#">
                            <div class="img"><img src="images/img/deta.jpg" /></div>
                            <div class="info">
                                <div class="name">【18个月】auby 澳贝生活体验馆1-3岁幼儿童玩具 早教 婴儿玩具</div>
                                <div class="price">
                                    <span class="price1">￥39</span>
                                    <span class="price2">￥98</span>
                                    <div class="range">
                                        <div class="range-main" style="width:39%"></div>
                                        <div class="num">39%</div>
                                    </div>
                                </div>
                                <div class="btn">
                                    <span class="red">去抢购</span>
                                </div>
                            </div>
                        </a></li>
                        <li><a href="#">
                            <div class="img"><img src="images/img/deta.jpg" /></div>
                            <div class="info">
                                <div class="name">【18个月】auby 澳贝生活体验馆1-3岁幼儿童玩具 早教 婴儿玩具</div>
                                <div class="price">
                                    <span class="price1">￥39</span>
                                    <span class="price2">￥98</span>
                                    <div class="range">
                                        <div class="range-main" style="width:100%"></div>
                                        <div class="num">100%</div>
                                    </div>
                                </div>
                                <div class="btn">
                                    <span class="gray">已售罄</span>
                                </div>
                            </div>
                        </a></li>
                    </ul>
                    <h3 class="seckill-title">10:00 正在进行中</h3>
                    <ul class="list-container">
                        <li><a href="#">
                            <div class="img"><img src="images/img/deta.jpg" /></div>
                            <div class="info">
                                <div class="name">【18个月】auby 澳贝生活体验馆1-3岁幼儿童玩具 早教 婴儿玩具</div>
                                <div class="price">
                                    <span class="price1">￥39</span>
                                    <span class="price2">￥98</span>
                                </div>
                                <div class="btn">
                                    <span class="orange">即将开抢</span>
                                    <p class="txt orange">限量500件</p>
                                </div>
                            </div>
                        </a></li>
                        <li><a href="#">
                            <div class="img"><img src="images/img/deta.jpg" /></div>
                            <div class="info">
                                <div class="name">【18个月】auby 澳贝生活体验馆1-3岁幼儿童玩具 早教 婴儿玩具</div>
                                <div class="price">
                                    <span class="price1">￥39</span>
                                    <span class="price2">￥98</span>
                                </div>
                                <div class="btn">
                                    <span class="orange">即将开抢</span>
                                    <p class="txt orange">限量500件</p>
                                </div>
                            </div>
                        </a></li>
                    </ul>
					*/
					?>
                </section>
            </div>

        </div>
        <div class="popup popup-share">
            <a href="javascript:;" class="close-popup"></a>
        </div>
    </div>
</body>

</html>

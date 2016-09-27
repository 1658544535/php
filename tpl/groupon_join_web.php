<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>淘竹马</title>
    <meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, minimal-ui, user-scalable=0" name="viewport">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <link rel="stylesheet" href="css/sm.min.css">
    <link rel="stylesheet" href="css/all.min.css">
</head>

<body>
    <div class="page-group" id="page-proTips">
        <div id="page-nav-bar" class="page page-current">
            <header class="bar bar-nav">
                <a class="button button-link button-nav pull-left back" href="">
                    <span class="icon icon-back"></span>
                </a>
                <h1 class="title">组团成功</h1>
            </header>

            <div class="content native-scroll">
				<?php if(($info['endDateline'] > $time) && ($info['groupNum'] > $info['joinNum'])){ ?>
					<section class="proTips-1">
						<div class="img"><img src="" /></div>
						<div class="info">
							<div class="txt1">您终于来了，快参团吧！</div>
							<div class="txt2">已有<?php echo $info['joinNum'];?>人参团，还差<?php echo $info['groupNum'] - $info['joinNum'];?>人，赶快分享召集小伙伴组团啦.</div>
						</div>
					</section>
				<?php }elseif($info['endDateline'] < $time){ ?>
					<?php if($info['groupNum'] > $info['joinNum']){ ?>
						<section class="proTips-1">
							<div class="img"><img src="" /></div>
							<div class="info">
								<div class="txt1">很遗憾，组团失败！</div>
								<div class="txt2">拼团期内未达到成团人数，系统会在1-2个工作日内，按原路自动退款至各位成员.</div>
							</div>
						</section>
					<?php }else{ ?>
						<section class="proTips-1">
							<div class="img"><img src="" /></div>
							<div class="info">
								<div class="txt1">恭喜你，参团成功！</div>
								<div class="txt2">小伙伴已集结完毕，商品会尽快向各位发货，请耐心等待.</div>
							</div>
						</section>
					<?php } ?>
				<?php } ?>

                <section class="freeList proTips-2">
                    <h3 class="title1">拼团商品</h3>
                    <ul class="list-container">
                        <li><a href="groupon.php?id=<?php echo $grouponId;?>">
                            <div class="img"><img src="<?php echo $info['productImage'];?>"></div>
                            <div class="info">
                                <div class="name"><?php echo $info['productName'];?></div>
                                <div class="price">
                                    <div class="btn">商品详情</div>
                                    拼团价：<span class="price1"><?php echo $info['groupPrice'];?></span>
                                    <span class="price2">￥<?php echo $info['alonePrice'];?></span>
                                </div>
                            </div>
                        </a></li>
                    </ul>
                </section>
                
                <section class="proTips-3">
                    <div class="title1">
						<?php if($info['endDateline'] > $time){ ?>
							<p class="time">本团将于<span id="downTime" data-timer="<?php echo $info['remainSec'];?>"></span>结束</p>
						<?php }elseif($info['endDateline'] < $time){ ?>
							<p class="time">本团已结束</p>
						<?php } ?>
                        <span>参团小伙伴</span>
                    </div>
                    <ul class="list">
						<?php if($info['endDateline'] > $time){ ?>
							<li class="join">
								<div class="img"></div>
								<div class="tips">已有<?php echo $info['joinNum'];?>人参团，还差<?php echo $info['groupNum']-$info['joinNum'];?>人，快加入我们吧！</div>
							</li>
						<?php }else{ ?>
							<?php if($info['joinNum'] < $info['groupNum']){ ?>
								<li class="fail">
									<div class="tips">组团时间到，未召集到相应人数的小伙伴！</div>
								</li>
							<?php }else{ ?>
								<?php foreach($joiners as $v){ ?>
									<li>
										<div class="img"><img src="<?php echo $v->image;?>" /></div>
										<div class="name">
											<?php if($v->is_head){ ?><span>团长</span><?php } ?>
											<p><?php echo $v->uname;?></p>
										</div>
										<div class="time"><?php echo $v->attend_time;?></div>
									</li>
								<?php } ?>
							<?php } ?>
						<?php } ?>
						
                    </ul>   
                </section>

                <section class="deta-tips proTips-4">
                    <h3>活动说明</h3>
                    <div><img src="images/deta-tips2.png" /></div>
                </section>

				<?php if($info['endDateline'] > $time){ ?>
					<section class="proTips-5">
						<a href="order_join.php?id=<?php echo $gouponId;?>&pid=<?php echo $info['productId'];?>">
							<div class="info">
								<?php echo $info['groupNum'];?>人成团&nbsp;&nbsp;当前团<?php echo $info['joinNum'];?>人 &nbsp;
								￥<span class="price1"><?php echo $info['groupPrice'];?></span>&nbsp;
								<span class="price2">￥<?php echo $info['alonePrice'];?></span>    
							</div>
							<span class="btn">我要拼团 ></span>
						</a>
					</section>
				<?php }else{ ?>
					<?php if($info['joinNum'] < $info['groupNum']){ ?>
						<section class="proTips-5">
							<a href="/">
								<div class="info">
									<?php echo $info['groupNum'];?>人成团&nbsp;&nbsp;当前团<?php echo $info['joinNum'];?>人 &nbsp;
									￥<span class="price1"><?php echo $info['groupPrice'];?></span>&nbsp;
									<span class="price2">￥<?php echo $info['alonePrice'];?></span>    
								</div>
								<span class="btn">更多拼团 ></span>
							</a>
						</section>
					<?php }else{ ?>
						<section class="proTips-5">
							<a href="/">
								<div class="info">
									<span class="late">来晚了</span>
									<?php echo $groupon['num'];?>人召集完毕&nbsp;
									￥<span class="price1"><?php echo $info['groupPrice'];?></span>
								</div>
								<span class="btn">更多拼团 ></span>
							</a>
						</section>
					<?php } ?>
				<?php } ?>
            </div>

        </div>
    </div>
    <script type='text/javascript' src='js/zepto.js' charset='utf-8'></script>
    <script type='text/javascript' src='js/sui/sm.min.js' charset='utf-8'></script>
    <script type='text/javascript' src='js/app.min.js' charset='utf-8'></script>
</body>

</html>

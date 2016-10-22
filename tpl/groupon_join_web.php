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
    <script src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>
	<script type="text/javascript" src="/js/wxshare.js"></script>
	<script type="text/javascript">
	var imgUrl = "<?php echo $info['productImage'];?>";
    var link = window.location.href;
	var title = "我买了<?php echo $info['groupPrice'];?>元的<?php echo $info['productName'];?>";
	var desc  = "<?php echo $info['productSketch'];?>。";
	wxshare(false, '<?php echo $wxShareParam['appId'];?>', <?php echo $wxShareParam['timestamp'];?>, '<?php echo $wxShareParam['nonceStr'];?>', '<?php echo $wxShareParam['signature'];?>', imgUrl, link, title, desc);
	</script>
</head>

<body>
    <div class="page-group" id="page-proTips">
        <div id="page-nav-bar" class="page page-current">
            <header class="bar bar-nav">
                <a class="button button-link button-nav pull-left back" href="index.php">
                    <span class="icon icon-back"></span>
                </a>
                <h1 class="title">
					<?php $pageHeadTitles = array(0=>'我要组团', 1=>'组团成功', 2=>'组团失败'); ?>
					<?php echo $pageHeadTitles[$info['status']];?>
				</h1>
            </header>

            <div class="content native-scroll">
				<section class="proTips-1">
					<?php switch($info['status']){
						case 0: ?>
							<input type="hidden" id="showShare" />
							<?php if($info['userIsHead'] == 1){ ?>
								<div class="txt1">
									<div class="img"><img src="images/tip-success.png" /></div>
									恭喜你，开团成功！
								</div>
								<div class="txt2">还差<?php echo $info['poorNum'];?>人，赶紧分享召集小伙伴组团啦！</div>
							<?php }elseif($info['isGroup'] == 0){ ?>
								<div class="txt1">
									<div class="img"><img src="images/tip-ing.png" /></div>
									您终于来了，快参团吧！
								</div>
								<div class="txt2">已有<?php echo $info['joinNum'];?>人参团，还差<?php echo $info['poorNum'];?>人，赶快分享召集小伙伴组团啦.</div>
							<?php } ?>
						<?php break; ?>
						<?php case 1: ?>
							<?php if($info['isGroup'] == 1){ ?>
								<div class="txt1">
									<div class="img"><img src="images/tip-success.png" /></div>
									恭喜您，拼团成功！
								</div>
								<div class="txt2">小伙伴已集结完毕，商品会尽快向各位发货，请耐心等待.</div>
							<?php }else{ ?>
								<div class="txt1">
									<div class="img"><img src="images/tip-fail.png" /></div>
									您来晚了，已经成团！
								</div>
								<div class="txt2">赶紧点击“我要开团”，疯抢起来吧！</div>
							<?php } ?>
						<?php break; ?>
						<?php case 2: ?>
							<div class="txt1">
								<div class="img"><img src="images/tip-fail.png" /></div>
								很遗憾，组团失败！
							</div>
							<div class="txt2">拼团期内未达到成团人数，系统会在1-2个工作日内，按原路自动退款至各位成员.</div>
						<?php break; ?>
					<?php } ?>
				</section>
	
                <section class="freeList proTips-2">
                    <h3 class="title1">拼团商品</h3>
                    <ul class="list-container">
                        <li><a href="groupon.php?id=<?php echo $grouponId;?>">
                            <div class="img"><img src="<?php echo $info['productImage'];?>"></div>
                            <div class="info">
                                <div class="name"><?php echo $info['productName'];?></div>
                                <div class="price">
                                    <div class="btn">商品详情</div>
                                    拼团价：<span class="price1">￥<?php echo $info['groupPrice'];?></span>
                                    <span class="price2">￥<?php echo $info['alonePrice'];?></span>
                                </div>
                            </div>
                        </a></li>
                    </ul>
                </section>
                
                <section class="proTips-3">
                    <div class="title1">
						<?php switch($info['status']){
							case 0: ?>
								<div class="time">本团将于<div id="downTime" data-timer="<?php echo $info['remainSec'];?>"></div>结束</div>
							<?php break; ?>
							<?php case 2: ?>
								<p class="time themeColor">本团已结束</p>
							<?php break; ?>
						<?php } ?>
                        <span>参团小伙伴</span>
                    </div>
                    <ul class="list">
						<?php foreach($info['groupUserList'] as $v){ ?>
							<li>
								<div class="img"><img src="<?php echo $v['userImage'];?>" /></div>
								<div class="name">
									<?php if($v['isHead']){ ?><span>团长</span><?php } ?>
									<p><?php echo $v['userName'];?></p>
								</div>
								<div class="time"><?php echo $v['joinTime'];?></div>
							</li>
						<?php } ?>
						<?php switch($info['status']){
							case 0: ?>
								<li class="join">
									<div class="img"></div>
									<div class="tips">
										已有<?php echo $info['joinNum'];?>人参团，还差<?php echo $info['poorNum'];?>人，快加入我们吧！
									</div>
								</li>
							<?php break; ?>
							<?php case 2: ?>
								<li class="fail">
									<div class="tips">组团时间到，未召集到相应人数的小伙伴！</div>
								</li>
							<?php break; ?>
						<?php } ?>
                    </ul>   
                </section>

                <section class="deta-tips proTips-4">
                    <h3>活动说明</h3>
                    <div><img src="images/deta-tips2.png" /></div>
                </section>

				<section class="proTips-5">
					<?php switch($info['status']){
						case 0: ?>
							<?php if($info['userIsHead'] == 1){ ?>
								<a href="/">
									<div class="info">
										<?php echo $info['groupNum'];?>人成团&nbsp;&nbsp;当前团<?php echo $info['joinNum'];?>人 &nbsp;
										￥<span class="price1"><?php echo $info['groupPrice'];?></span>
									</div>
									<span class="btn">更多拼团 ></span>
								</a>
							<?php }elseif($info['isGroup'] == 0){ ?>
								<a href="order_join.php?id=<?php echo $grouponId;?>&pid=<?php echo $info['productId'];?>&free=<?php echo $isGrouponFree;?>&aid=<?php echo $attendId;?>">
									<div class="info">
										<?php echo $info['groupNum'];?>人成团&nbsp;&nbsp;当前团<?php echo $info['joinNum'];?>人 &nbsp;
										￥<span class="price1"><?php echo $info['groupPrice'];?></span>
									</div>
									<span class="btn">我要拼团 ></span>
								</a>
							<?php } ?>
						<?php break; ?>
						<?php case 1: ?>
							<?php if($info['isGroup'] == 1){ ?>
								<a href="/">
									<div class="info">
										<?php echo $info['groupNum'];?>人召集完毕&nbsp;&nbsp;
										￥<span class="price1"><?php echo $info['groupPrice'];?></span>
									</div>
									<span class="btn">更多拼团 ></span>
								</a>
							<?php }else{ ?>
								<a href="/">
									<div class="info">
										马上开团
									</div>
									<span class="btn">更多拼团 ></span>
								</a>
							<?php } ?>
						<?php break; ?>
						<?php case 2: ?>
							<a href="/">
								<div class="info">
									<?php echo $info['groupNum'];?>人成团&nbsp;&nbsp;当前团<?php echo $info['joinNum'];?>人 &nbsp;
									￥<span class="price1"><?php echo $info['groupPrice'];?></span>
								</div>
								<span class="btn">更多拼团 ></span>
							</a>
						<?php break; ?>
					<?php } ?>
				</section>
            </div>
			
        </div>

        <?php if($showBlack){ ?>
        <div class="popup popup-share popup-share2">
            <a href="javascript:;" class="close-popup"></a>
            <div class="">
            	<div class="s-1">还差 <span><?php echo $info['poorNum'];?></span> 人，邀请好友参团吧</div>
            	<div class="s-2">点击右上角按钮，发送给朋友或群聊</div>
            	<div class="s-3">拼团人数不足退款</div>
            </div>
        </div>
        <?php } ?>
    </div>
    <script type='text/javascript' src='js/zepto.js' charset='utf-8'></script>
    <script type='text/javascript' src='js/sui/sm.min.js' charset='utf-8'></script>
    <script type='text/javascript' src='js/app.min.js' charset='utf-8'></script>
</body>

</html>

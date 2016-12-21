<?php include_once('header_notice_web.php');?>
<script type="text/javascript" src="/js/jweixin-1.0.0.js"></script>
<script type="text/javascript" src="/js/wxshare.js"></script>
<script type="text/javascript">
    var imgUrl = "<?php echo $fx['image'];?>";
    var link   = "<?php echo $fx['url'];?>";
    var title  = "<?php echo $fx['title'];?>";
    var desc   = "<?php echo $fx['content'];?>";
    wxshare(false, '<?php echo $wxShareParam['appId'];?>', <?php echo $wxShareParam['timestamp'];?>, '<?php echo $wxShareParam['nonceStr'];?>', '<?php echo $wxShareParam['signature'];?>', imgUrl, link, title, desc);
</script>
<?php if($userid==171){ ?>
<script language="javascript">
$(function(){
    $("a.zswtest").on("click", function(){
        console.log($(this).attr("href"));
    });
});
</script>
<?php } ?>

<body>
    <div class="page-group" id="page-seckill">
        <div id="page-nav-bar" class="page page-current">
            <header class="bar bar-nav">
                <a class="button button-link button-nav pull-left back" href="/">
                    <span class="icon icon-back"></span>
                </a>
                <a class="button button-link button-nav pull-right share" href="javascript:;">
                    <span class="icon icon-share"></span>
                </a>
                <h1 class="title">掌上秒杀</h1>
            </header>

            <nav class="bar bar-tab">
                <a class="tab-item tab-item2<?php if($type == 1){ ?> active<?php } ?> zswtest" href="seckill.php">
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
                    <?php if($type == 1){ ?><a href="sellout.php" class="seckill-out">查看今天已售罄商品</a><?php } ?>
                    <?php if(empty($info)){ ?>
                        <div style="height:1px;"></div>
                        <div class="list-null">暂无秒杀的商品</div>
					<?php }else{ ?>
						<?php foreach($info as $_info){ ?>
							<h3 class="seckill-title<?php if($_info['isStart']==1){ ?> active<?php } ?>" style="font-weight:bold;font-size:15px"><?php echo $_info['time'];?><?php if($_info['isStart']==1){ ?> 正在进行中<?php } ?></h3>
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
												<?php if($_info['isStart']==1){?>
													<div class="range">
														<div class="range-main" style="width:<?php echo $v['salePerce'];?>%"></div>
														<div class="num"><?php echo $v['salePerce'];?>%</div>
													</div>
												<?php }?>
												</div>
												<div class="btn">
													<?php if($_info['isStart'] == 1){ ?>
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
					<?php } ?>
                </section>
            </div>

        </div>
        <div class="popup popup-share">
            <a href="javascript:;" class="close-popup"></a>
        </div>
        <section id="goTop" class="goTop"></section>
    </div>
</body>

</html>

<?php include_once('header_notice_web.php');?>
<?php include_once('wxshare_web.php');?>

<body>
    <div class="page-group" id="page-logistics">
        <div id="page-nav-bar" class="page page-current">
            <header class="bar bar-nav">
                <a class="button button-link button-nav pull-left back" href="javascript:history.back(-1);">
                    <span class="icon icon-back"></span>
                </a>
                <h1 class="title">查看物流</h1>
            </header>

            <?php include_once('footer_nav_web.php');?>

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

        </div>
    </div>
</body>

</html>

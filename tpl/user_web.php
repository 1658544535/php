<?php include_once('header_new_web.php');?>
<?php include_once('wxshare_web.php');?>
<body>
    <div class="page-group" id="page-user">
        <div id="page-nav-bar" class="page page-current">

			<?php include_once('footer_nav_web.php');?>
            <div class="content native-scroll">
                <section class="user-header">
                    <div class="photo">
                        <div class="img">
							<?php if($bLogin){ ?>
								<img src="<?php echo $info['userImage'];?>"/>
							<?php }else{ ?>
								<a href="/user_binding.php">
									<img src="<?php echo $info['userImage'];?>"/>
								</a>
							<?php } ?>
						</div>
                    </div>
                    <?php if($bLogin){?>
                    <div class="name"><?php echo $info['name']; ?></div>
                    <?php }else{?>
                    <div class="name"><?php echo $_wxUserInfo['nickname']; ?></div>
                    <?php }?>
                    <div class="orderTips">
                    <?php if($info['waitPayNum'] > 0){ ?>
                        <a href="user_orders.php?type=1">还有<span class="themeColor"><?php echo $info['waitPayNum'];?>个订单</span>未付款 ></a>
                    <?php } ?>
                    </div>
                    <ul class="orderTab">
                        <li><a href="user_orders.php?type=2">
                            <span><?php echo $info['groupingNum'];?></span>
                            <p>拼团中</p>
                        </a></li>
                        <li><a href="user_orders.php?type=21">
                            <span><?php echo $info['waitSendNum'];?></span>
                            <p>待发货</p>
                        </a></li>
                        <li><a href="user_orders.php?type=3">
                            <span><?php echo $info['waitRecNum'];?></span>
                            <p>待收货</p>
                        </a></li>
                        <li><a href="user_orders.php?type=4">
                            <span><?php echo $info['waitComNum'];?></span>
                            <p>已完成</p>
                        </a></li>
                        <li><a href="aftersale.php">
                            <span><?php echo $info['saleSerNum'];?></span>
                            <p>退款/售后</p>
                        </a></li>
                    </ul>
                </section>

				<?php if($info['isGroupFree']){ ?>
                <section class="user-coupon-show">
                    <div class="freeCoupon" id="free-coupon">
                        <div class="info">
                            <div class="name">团长免单券 <span>(团长免费开团)</span></div>
                            <div class="tips">点击选择团免商品</div>
                            <div class="time">有效期: <?php echo date('Y.n.j', $info['couponBTime']);?>-<?php echo date('Y.n.j', $info['couponETime']);?></div>
                        </div>
                        <div class="price"><div>￥<span>0</span></div></div>
                    </div>
                </section>
				<script type="text/javascript">
				$(function(){
					$("#free-coupon").on("click", function(){
						window.location.href = "groupon_free.php";
					});
				});
				</script>
				<?php } ?>

               <?php if($info['pindeke'] ==1){?>
                <section class="user-pdk">
                    <h3 class="title1"><i></i>拼得客管理中心</h3>
                    <ul>
                        <li><a href="/pindeke.php?act=pdkInfo&uid=<?php echo $userid;?>"><i class="u-p-1"></i>我的信息</a></li>
                        <li><a href="/pindeke.php?act=wallet&uid=<?php echo $userid;?>"><i class="u-p-2"></i>我的钱包</a></li>
                        <li><a href="/pindeke.php?act=QRcode&uid=<?php echo $userid;?>"><i class="u-p-3"></i>团免链接</a></li>
                    </ul>
                </section>
               <?php }?>

                <section class="user-list">
                    <ul>
                        <li><a href="/user_info.php?act=coupon"><i class="u-l-1"></i>我的优惠券</a></li>
                        <li><a href="/user_info.php?act=groupon"><i class="u-l-2"></i>我的拼团</a></li>
                        <li><a href="/user_info.php?act=guess"><i class="u-l-3"></i>我的猜价</a></li>
                        <li><a href="/user_lottery.php?uid=<?php echo $userid;?>"><i class="u-l-6"></i>我的抽奖</a></li>
                        <li><a href="/user_info?act=product_collect"><i class="u-l-4"></i>我的收藏</a></li>
                        <li><a href="/address?act=manage"><i class="u-l-5"></i>收货地址</a></li>
                    </ul>
                </section>
            </div>
        </div>
    </div>
</body>

</html>

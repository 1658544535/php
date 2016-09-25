<nav class="bar bar-tab">
	<a class="tab-item <?php echo ($footerNavActive=='index')?'active':'';?>" href="/">
		<span class="icon i-home"></span>
		<span class="tab-label">首页</span>
	</a>
	<a class="tab-item <?php echo ($footerNavActive=='guess')?'active':'';?>" href="product_guess_price.php">
		<span class="icon i-price"></span>
		<span class="tab-label">猜价格</span>
	</a>
	<a class="tab-item <?php echo ($footerNavActive=='search')?'active':'';?>" href="#">
		<span class="icon i-search"></span>
		<span class="tab-label">搜索</span>
	</a>
	<a class="tab-item <?php echo ($footerNavActive=='user')?'active':'';?>" href="user.php">
		<span class="icon i-user"></span>
		<span class="tab-label">个人中心</span>
	</a>
</nav>
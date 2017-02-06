<section class="sidebar">
    <ul class="sidebar-menu">
        <li class="header">菜单</li>
        <li class="treeview active js-access" data-access="1,2,6,7">
            <a href="<?php echo url('LuoDiYe');?>" target="iFrameContent"><i class="fa fa-home"></i> <span>落地页</span></a>
        </li>
		<li>
			<a href="#"><i class="fa fa-tachometer"></i> <span>微信红包</span>
                <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                </span>
            </a>
			<ul class="treeview-menu">
				<li><a href="<?php echo url('WxHongbao');?>" target="iFrameContent">红包口令</a></li>
				<li><a href="<?php echo url('WxHongbao', 'receiveLog');?>" target="iFrameContent">领取记录</a></li>
			</ul>
		</li>
        <li>
            <a href="#"><i class="fa fa-tachometer"></i> <span>转盘抽奖</span>
                <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                </span>
            </a>
            <ul class="treeview-menu">
                <li><a href="<?php echo url('Turntable');?>" target="iFrameContent">活动</a></li>
            </ul>
        </li>
    </ul>
</section>
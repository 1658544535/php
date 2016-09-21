<ul class="sidebar-list">
    <li>
    	<a href="#"><strong>刷单管理</strong></a>
        <ul class="sub-menu">
        	<li>
            	<a href="<?php echo $site_admin; ?>">
            		|— 基本信息
            	</a>
             </li>

        	 <li>
            	<a href="<?php echo $site_admin; ?>order.php?act=list">
            		|— 代付订单
            	</a>
             </li>

        	 <li>
            	<a onclick="add()">
            		|— <span style='color:red; cursor:pointer;'>点击开始刷单</span>
            	</a>
            </li>
        </ul>

        <a href="#"><strong>刷单设置管理</strong></a>
        <ul class="sub-menu">
            <li>
            	<a href="<?php echo $site_admin; ?>setting.php?act=list">
            		|— 基本设置
            	</a>
            </li>

            <li>
            	<a href="<?php echo $site_admin; ?>setting.php?act=temp_edit">
            		|— 临时设置
            	</a>
            </li>

            <li>
            	<a href="<?php echo $site_admin; ?>setting.php?act=auto">
            		|— 批量刷单设置
            	</a>
            </li>
        </ul>

		<?php if ( $market_type == 99 ){ ?>
	        <a href="#"><strong>快递管理</strong></a>
	        <ul class="sub-menu">
	        	<li>
	            	<a href="<?php echo $site_admin; ?>express.php?act=list">
	            		|— 快递单号列表
	            	</a>
	            </li>

	        	<li>
	            	<a href="<?php echo $site_admin; ?>express.php">
	            		|— 导入快递单号
	            	</a>
	            </li>

	            <li>
	            	<a href="<?php echo $site_admin; ?>express.php?act=run">
	            		|— 订单设置运单号
	            	</a>
	            </li>
	        </ul>
	    <?php } ?>
    </li>

</ul>

<script>
	function add()
	{
		if ( confirm('点击确认开始刷单！') == true )
		{
			location.href="<?php echo $site_admin; ?>index.php?act=add";
		}
	}
</script>

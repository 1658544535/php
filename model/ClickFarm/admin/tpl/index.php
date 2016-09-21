    <!--/sidebar-->
    <div class="main-wrap">

        <div class="crumb-wrap">
            <div class="crumb-list">
            	<i class="icon-font"></i><a href="index.php">首页</a><span class="crumb-step">&gt;</span>
            	基本信息
            </div>
        </div>

        <div class="result-wrap">
         	<h2>待刷商品列表</h2>
            <div class="result-content">
                <table class="result-tab" width="100%">
                    <tr>
                    	<td>产品编号</td>
                    	<td>产品名称</td>
                    	<td>产品单价</td>
                    	<td>产品图片</td>
                    	<td>产地</td>
                    </tr>
                    <?php if ( is_array($arrProductList) ){ ?>
                    	<?php foreach( $arrProductList as $arr ){ ?>
                        <tr>
                            <td><?php echo $arr->id; ?></td>
                            <td><?php echo $arr->product_name; ?></td>
                            <td><?php echo $arr->distribution_price; ?></td>
                            <td><img src="<?php echo $site_image; ?>product/small/<?php echo $arr->image; ?>" width="50" /> </td>
                            <td><?php echo $arr->location; ?></td>
                        </tr>
                    <?php }}else{ ?>
                    	<tr>
                    		<td colspan='6'>您查找的记录为空！</td>
                    	</tr>
                    <?php } ?>
                </table>
            </div>

            <h2 style="margin-top:20px;">待刷用户列表</h2>
            <div class="result-content">
                <table class="result-tab" width="100%">
                    <tr>
                    	<td>用户编号</td>
                    	<td>帐号</td>
                    	<td>用户名</td>
                    </tr>
                    <?php if ( is_array($arrUserList) ){ ?>
                    	<?php foreach( $arrUserList as $arr ){ ?>
                        <tr>
                            <td><?php echo $arr->id; ?></td>
                            <td><?php echo $arr->loginname; ?></td>
                            <td><?php echo $arr->name; ?></td>
                        </tr>
                    <?php }}else{ ?>
                    	<tr>
                    		<td colspan='6'>您查找的记录为空！</td>
                    	</tr>
                    <?php } ?>
                </table>
            </div>
        </div>

    </div>
    <!--/main-->
</div>

</body>
</html>

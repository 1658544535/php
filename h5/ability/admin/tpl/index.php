<style>
    .result-tab th, .result-tab td{width:20%;text-align:center;}
</style>
    <!--/sidebar-->
    <div class="main-wrap">

        <div class="crumb-wrap">
            <div class="crumb-list">
            	<i class="icon-font"></i><a href="index.php">首页</a><span class="crumb-step">&gt;</span>
            	测试概况
            </div>
        </div>

        <div class="result-wrap">
         	<h2>页面流量概况</h2>
            <div class="result-content">
                <table class="result-tab" width="100%">
                    <tr>
                    	<td>类别</td>
                    	<td>第一个页面PV/UV</td>
                    	<td>第二个页面PV/UV</td>
                    	<td>第三个页面PV/UV</td>
                    	<td>重测UV</td>
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
                            <td><a target="_blank"  href="https://web.umeng.com/main.php?c=site&a=show" class="show-view btn">查看详情</a></td>
                        </tr>
                    <?php } ?>
                </table>
            </div>

            <h2 style="margin-top:20px;">详细数据</h2>
            <div class="result-content">
                <table class="result-tab" width="100%">
                    <tr>
                    	<td>日期</td>
                    	<td>第一个页面PV/UV</td>
                        <td>第二个页面PV/UV</td>
                        <td>第三个页面PV/UV</td>
                        <td>重测UV</td>
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
                    		 <td ><a target="_blank"  href="https://web.umeng.com/main.php?c=site&a=show" class="show-view btn">查看详情</a></td>
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

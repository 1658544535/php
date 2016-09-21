    <!--/sidebar-->
    <div class="main-wrap">

        <div class="crumb-wrap">
            <div class="crumb-list">
            	<i class="icon-font"></i><a href="index.php">首页</a><span class="crumb-step">&gt;</span>
            	<span class="crumb-name">活动列表</span>
            </div>
        </div>
<!--
        <?php if ( $market_type == 1 ){ ?>
        <div class="search-wrap">
            <div class="search-content">
                <form action="/admin/test.php" method="post">
                    <table class="search-tab">
                        <tr>
                            <th width="120">编号：</th>
                        	<td><input class="common-text" placeholder="编号" name="pid" value="" type="text"></td>
                            <th width="100">名称:</th>
                            <td><input class="common-text" placeholder="名称" name="name" value="" type="text"></td>
                            <th width="100">手机号：</th>
                        	<td><input class="common-text" placeholder="手机号" name="mobile" value="" type="text"></td>
                            <td><input class="btn btn-primary btn2" name="sub" value="查询" type="submit"></td>
                        </tr>
                    </table>
                </form>
            </div>
        </div>

        <div class="list-page" style="text-align:left; margin:0px 20px;">
			<a href="/admin/test.php?act=add">新增推广员</a>
		</div>
		<?php } ?>
-->
		<div class="list-page" style="text-align:left; margin:0px 20px;">
			<a href="<?php echo $site_admin; ?>activity.php?act=add">新增活动</a>
		</div>

        <div class="result-wrap">
            <form name="myform" id="myform" method="post">
                <div class="result-content">
                    <table class="result-tab" width="100%">
                        <tr>
                            <th>活动编号</th>
                            <th>活动主题</th>
                            <th>开始时间</th>
                            <th>结束时间</th>
                            <th>状态</th>
                            <th>操作</th>
                        </tr>
                        <?php if ( is_array($arrRecord) ){ ?>
                        	<?php foreach( $arrRecord as $arr ){ ?>
	                        <tr>
	                            <td><?php echo $arr->id; ?></td>
	                            <td><?php echo $arr->title; ?></td>
	                            <td><?php echo date("Y-m-d H:i:s", $arr->starttime ); ?></td>
	                            <td><?php echo date("Y-m-d H:i:s", $arr->endtime ); ?></td>
	                            <td><?php echo ( $arr->status == 1 ) ? '进行中' : '已关闭'; ?></td>
	                            <td>
	                            <a href="<?php echo $site_admin;?>activity.php?act=edit&id=<?php echo $arr->id; ?>" style="color:#000;">编辑</a> |
	                           	<?php if( $market_type == 1 ){ ?>
	                           		<a href="<?php echo $site_admin;?>prize.php?act=list&id=<?php echo $arr->id; ?>" style="color:#000;">活动商品</a> |
	                            	<a href="<?php echo $site_admin;?>records.php?act=list&id=<?php echo $arr->id; ?>" style="color:#000;">获奖记录</a> |
	                            	<a href="<?php echo $site_admin;?>link.php?act=list&id=<?php echo $arr->id; ?>" style="color:#000;">参与记录</a>
	                            <?php } ?>

	                        </tr>
                        <?php }}else{ ?>
                        	<tr>
                        		<td colspan='6'>您查找的记录为空！</td>
                        	</tr>
                        <?php } ?>
                    </table>

                </div>
            </form>
        </div>
    </div>
    <!--/main-->
</div>

</body>
</html>
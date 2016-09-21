    <!--/sidebar-->
    <div class="main-wrap">

        <div class="crumb-wrap">
            <div class="crumb-list">
            	<i class="icon-font"></i><a href="index.php">首页</a><span class="crumb-step">&gt;</span>
            	<a class="crumb-name" href="<?php echo $site_admin; ?>/activity.php?act=list">活动列表</a><span class="crumb-step">&gt;</span>
            	<span class="crumb-name">奖品列表</span>
            </div>
        </div>

		<div class="list-page" style="text-align:left; margin:0px 20px;">
			<a href="<?php echo $site_admin; ?>prize.php?act=add&aid=<?php echo $_GET['id']; ?>">新增奖品</a>
		</div>

        <div class="result-wrap">
            <form name="myform" id="myform" method="post">
                <div class="result-content">
                    <table class="result-tab" width="100%">
                        <tr>
                        	<th>奖项</th>
                            <th>奖品名称</th>
                            <th>奖品图片</th>
                            <th>奖品价值</th>
                            <th>概率</th>
                            <th>状态</th>
                            <th>操作</th>
                        </tr>
                        <?php if ( is_array($arrRecord) ){ ?>
                        	<?php foreach( $arrRecord as $arr ){ ?>
	                        <tr>
	                        	<td><?php echo $arr->prize_no; ?></td>
	                            <td><?php echo $arr->name; ?></td>
	                            <td><img src="<?php echo $site;?>/upfiles/<?php echo $arr->image; ?>" width='120'  /></td>
	                            <td><?php echo $arr->price; ?></td>
	                            <td><?php echo $arr->probability; ?>%</td>
	                            <td><?php echo ($arr->status == 1) ? '有效' : '无效'; ?></td>
	                            <td>
	                            	<a href="<?php echo $site_admin;?>prize.php?act=edit&id=<?php echo $arr->id; ?>&aid=<?php echo $arr->shake_id; ?>" style="color:#000;">编辑</a>
	                            </td>
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
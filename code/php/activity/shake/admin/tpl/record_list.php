    <!--/sidebar-->
    <div class="main-wrap">

        <div class="crumb-wrap">
            <div class="crumb-list">
            	<i class="icon-font"></i><a href="index.php">首页</a><span class="crumb-step">&gt;</span>
            	<a class="crumb-name" href="<?php echo $site_admin; ?>/activity.php?act=list">活动列表</a><span class="crumb-step">&gt;</span>
            	<span class="crumb-name">兑奖列表</span>
            </div>
        </div>

        <div class="result-wrap">
            <form name="myform" id="myform" method="post">
                <div class="result-content">
                    <table class="result-tab" width="100%">
                        <tr>
                            <th>用户ID</th>
                            <th>用户昵称</th>
                            <th>是否关注</th>
                            <th>奖品</th>
                            <th>获奖时间</th>
                            <th>操作</th>
                        </tr>
                        <?php if ( is_array($arrRecord) ){ ?>
                        	<?php foreach( $arrRecord as $arr ){ ?>
	                        <tr>
	                            <td><?php echo $arr->userid; ?></td>
	                            <td><?php echo $arr->nickname; ?></td>
	                            <td><?php echo $arr->subscribe; ?></td>
	                            <td><?php echo $arr->prize_name; ?></td>
	                            <td><?php echo date("Y-m-d H:i:s", $arr->addtime ); ?></td>
	                            <td>
									<a onclick="del(<?php echo $arr->id ?>)">删除</a>
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

<script>

	function del( id )
	{
		if ( confirm('确定要删除么？') )
		{
			$.ajax({
				url:  <?php $site?>'records.php?act=del&rid=' + id,
				success:function(data){
					alert('删除成功！');
					location.reload();
				}
			})
		}
	}
</script>

</body>
</html>
	<link href="css/layer.css" rel="stylesheet" type="text/css" />

    <!--/sidebar-->
    <div class="main-wrap">

        <div class="crumb-wrap">
            <div class="crumb-list">
            	<i class="icon-font"></i><a href="index.php">首页</a><span class="crumb-step">&gt;</span>
            	价格差异列表
            </div>
        </div>

        <div class="result-wrap">
	       	<div class="search-wrap">
	            <div class="search-content">
	                <form action="" method="get">
	                    <table class="search-tab">
	                        <tr>
	                        	<th width="100" >时间：</th>
	                        	<td colspan="3">
	                        		<input  class="common-text"  name="act" id="act"  value="list" type="hidden">
	                        		<input style="width:150px;"  class="common-text"  name="addtime" id="addtime"  placeholder="时间" value="<?php echo $addtime; ?>" type="text">                     
	                        	</td>

	                        	<th width="100" >产品ID：</th>
	                        	<td colspan="3">
	                        		<input style="width:180px;"  class="common-text"  name="pid" id="pid"  placeholder="产品ID" value="<?php echo $pid; ?>" type="text">
	                        	</td>
                                
								<td>
								  <input class="btn btn-primary btn2" name="sub" value="查询" type="submit" style="float:right;" />
								</td>
	                        </tr>
	                    </table>
	                </form>
	            </div>
	        </div>

	        <!-- <div class="list-page" style="text-align:right; margin:0px 20px;">
				<a href="<?php echo $outputLink; ?>">导出EXCEL</a>
			</div> -->
           <h2>价格差异列表</h2>
            <div class="result-content">      
                <table class="result-tab" width="100%">
                	<tr>
                		<th>商品ID</th>
                		<th>b2c商品价格</th>
                		<th>天猫商品价格</th>
                		<th>添加时间</th>
                	</tr>

                    <?php if ( is_array($infoList['DataSet']) ){ ?>
                    	<?php foreach( $infoList['DataSet'] as $arr ){
                    		?>
                        <tr>                       	
                        	<td><?php echo $arr->pid; ?></td>
                            <td>￥<?php echo $arr->b_price; ?></td>
                            <th>￥<?php echo $arr->t_price; ?></th>
                            <!--<td>￥<?php echo $arr->old_b_price; ?></td>
                            <th>￥<?php echo $arr->old_t_price; ?></th>-->
                            <td><?php echo $arr->addtime; ?></td>
                                               
                        </tr>
                    <?php }}else{ ?>
                    	<tr>
                    		<td colspan='10'>您查找的记录为空！</td>
                    	</tr>
                    <?php } ?>
                </table>
            </div>

			<?php if ( is_array($infoList['DataSet']) ){ ?>
	           <div style="float:left; width:800px; margin:20px 0 10px;">
	            	<p>
	            		共 <?php echo $infoList['RecordCount']; ?> 条纪录，
	            		当前第<?php echo $infoList['CurrentPage']; ?>/<?php echo $infoList['PageCount']; ?>页，
	            		每页<?php echo $infoList['PageSize']; ?>条纪录
	            		<a href="<?php echo $url . '&page=' . $infoList['First']; ?>">[第一页]</a>
	            		<a href="<?php echo $url . '&page=' . $infoList['Prev']; ?>">[上一页]</a>
	            		<a href="<?php echo $url . '&page=' . $infoList['Next']; ?>">[下一页]</a>
	            		<a href="<?php echo $url . '&page=' . $infoList['Last']; ?>">[最后一页]</a>
	            	</p>
	           </div>
		 <?php } ?>
		 
        </div>
    </div>
    <!--/main-->
</div>
 
<script src="js/layer.js" type="text/javascript"></script>

<script>
	function showRule(oid)
	{
		$('html,body').css('overflow','hidden');
		$.ajax({
			url:'?act=getQrCode&order_id=' +  oid + '&temp=' +  Math.random(),
			success:function(data){
				layer.open({
				    content: data,
				    btn: ['关闭'],
				    end:function(elem){
						$('html,body').css('overflow','inherit');
				    }
				});
			}
		})

	}
</script>

</body>
</html>

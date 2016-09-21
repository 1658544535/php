	<link href="css/layer.css" rel="stylesheet" type="text/css" />

    <!--/sidebar-->
    <div class="main-wrap">

        <div class="crumb-wrap">
            <div class="crumb-list">
            	<i class="icon-font"></i><a href="index.php">首页</a><span class="crumb-step">&gt;</span>
            	代付订单
            </div>
        </div>

        <div class="result-wrap">
         	<h2>刷单订单列表</h2>
	       	<div class="search-wrap">
	            <div class="search-content">
	                <form action="" method="get">
	                    <table class="search-tab">
	                        <tr>
	                        	<th width="100" >时间：</th>
	                        	<td colspan="3">
	                        		<input  class="common-text"  name="act" id="act"  value="list" type="hidden">
	                        		<input style="width:150px;"  class="common-text"  name="sdate" id="sdate"  placeholder="开始时间" value="<?php echo $sdate; ?>" type="text"> -
	                        		<input style="width:150px;"  class="common-text"  name="edate" id="edate"  placeholder="结束时间" value="<?php echo $edate; ?>" type="text">
	                        	</td>

	                        	<th width="100" >订单ID：</th>
	                        	<td colspan="3">
	                        		<input style="width:180px;"  class="common-text"  name="oid" id="sdate"  placeholder="订单ID" value="<?php echo $order_no; ?>" type="text">
	                        	</td>

	                        	<th width="100" >订单状态：</th>
	                        	<td colspan="3">
	                        		<select name="order_status" class="common-text">
	                        			<option value=''  <?php echo $order_status == '' ? 'SELECTED' : '' ?> >全部</option>
	                        			<option value='1' <?php echo $order_status == 1  ? 'SELECTED' : '' ?> >待付款</option>
	                        			<option value='2' <?php echo $order_status == 2  ? 'SELECTED' : '' ?> >已付款</option>
	                        			<option value='3' <?php echo $order_status == 3  ? 'SELECTED' : '' ?> >已发货</option>
	                        			<option value='4' <?php echo $order_status == 4  ? 'SELECTED' : '' ?> >已确认</option>
	                        			<option value='5' <?php echo $order_status == 5  ? 'SELECTED' : '' ?> >已评论</option>
	                        		</select>
	                        	</td>

								<td>
								  <input class="btn btn-primary btn2" name="sub" value="查询" type="submit" style="float:right;" />
								</td>
	                        </tr>
	                    </table>
	                </form>
	            </div>
	        </div>

	        <div class="list-page" style="text-align:right; margin:0px 20px;">
				<a href="<?php echo $outputLink; ?>">导出EXCEL</a>
			</div>

            <div class="result-content">
                <table class="result-tab" width="100%">
                	<tr>
                		<th>ID</th>
                		<th>用户ID</th>
                		<th>订单ID</th>
                		<th>收货人</th>
                		<th>生成时间</th>
                		<th>应付金额</th>
                		<th>订单状态</th>
                		<th>产品图片</th>
                		<th>操作</th>
                	</tr>

                    <?php if ( is_array($arrUserOrderList['DataSet']) ){ ?>
                    	<?php foreach( $arrUserOrderList['DataSet'] as $arr ){ ?>
                        <tr>
                        	<td><?php echo $arr->id; ?></td>
                        	<td><?php echo $arr->user_id; ?></td>
                            <td><?php echo $arr->order_no; ?></td>
                            <td><?php echo $arr->consignee; ?></td>
                            <td><?php echo $arr->create_date; ?></td>
                            <td><?php echo $arr->all_price; ?></td>
                           	<td><?php echo $arrOrderStatus[$arr->order_status]; ?></td>
                            <td><?php echo $arr->product_image == '' ? '' : "<img src='http://b2c.taozhuma.com/upfiles//product/small/{$arr->product_image}' width='50' />" ; ?></td>
                            <td>
                            	<?php if($arr->order_status == 1){ ?><a onclick="showRule(<?php echo $arr->id; ?>)">刷新二维码</a> |<?php } ?>
                            	<a href="order.php?act=info&id=<?php echo $arr->id; ?>">详情</a>
                            </td>
                        </tr>
                    <?php }}else{ ?>
                    	<tr>
                    		<td colspan='10'>您查找的记录为空！</td>
                    	</tr>
                    <?php } ?>
                </table>
            </div>

			<?php if ( is_array($arrUserOrderList['DataSet']) ){ ?>
	           <div style="float:left; width:800px; margin:20px 0 10px;">
	            	<p>
	            		共 <?php echo $arrUserOrderList['RecordCount']; ?> 条纪录，
	            		当前第<?php echo $arrUserOrderList['CurrentPage']; ?>/<?php echo $arrUserOrderList['PageCount']; ?>页，
	            		每页<?php echo $arrUserOrderList['PageSize']; ?>条纪录
	            		<a href="<?php echo $url . '&page=' . $arrUserOrderList['First']; ?>">[第一页]</a>
	            		<a href="<?php echo $url . '&page=' . $arrUserOrderList['Prev']; ?>">[上一页]</a>
	            		<a href="<?php echo $url . '&page=' . $arrUserOrderList['Next']; ?>">[下一页]</a>
	            		<a href="<?php echo $url . '&page=' . $arrUserOrderList['Last']; ?>">[最后一页]</a>
	            	</p>
	           </div>

	           <div style="float:right; width:200px; margin:20px 0 10px;">
					当前订单总额：<a style="font-weight:bold;">￥<?php echo $fAllPrice; ?></a>
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

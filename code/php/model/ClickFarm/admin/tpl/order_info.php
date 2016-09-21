    <!--/sidebar-->
    <div class="main-wrap">

        <div class="crumb-wrap">
            <div class="crumb-list">
            	<i class="icon-font"></i>
            	<a href="index.php">首页</a><span class="crumb-step">&gt;</span>
            	<a href="order.php?act=list">代付订单</a><span class="crumb-step">&gt;</span>
            	订单详情
            </div>
        </div>

        <div class="result-wrap">
         	<h2>订单详情</h2>
            <div class="result-content">
                <table class="result-tab" width="100%">
                	<tr>
                		<th>用户昵称:</th>
                		<th><?php echo $data->name; ?></th>
                		<th>支付宝单号:</th>
                		<th><?php echo $data->out_trade_no; ?></th>
                	</tr>
                	<tr>
                		<th>订单号:</th>
                		<th><?php echo $data->order_no; ?></th>
                		<th>物流信息:</th>
                		<th><?php echo $data->name; ?></th>
                	</tr>
                	<tr>
                		<th>订单原价:</th>
                		<th><?php echo $data->all_price; ?></th>
                		<th>实收金额:</th>
                		<th><?php echo $data->fact_price; ?></th>
                	</tr>
                	<tr>
                		<th>收货人:</th>
                		<th><?php echo $data->consignee; ?></th>
                		<th>收货人电话:</th>
                		<th><?php echo $data->consignee_phone; ?></th>
                	</tr>
                	<tr>
                		<th>收货人方式 :</th>
                		<th><?php echo $data->consignee_type == 1 ? '快递' : '自提'; ?></th>
                		<th>收货地址:</th>
                		<th><?php echo $data->consignee_address; ?></th>
                	</tr>
                	<tr>

                		<th>发货人:</th>
                		<th></th>
                		<th>发货人电话：</th>
                		<th></th>
                	</tr>
                	<tr>
                		<th>客服留言:</th>
                		<th><?php echo $data->remarks; ?></th>
                		<th>买家留言:</th>
                		<th><?php echo $data->buyer_message; ?></th>
                	</tr>
                	<tr>
                		<th>钱包支付金额:</th>
                		<th><?php echo $data->wallet_price; ?></th>
                		<th>发货地址:</th>
                		<th></th>
                	</tr>
                	<tr>
                		<th>优惠券券码:</th>
                		<th><?php echo $data->discount_context; ?></th>
                		<th>优惠金额:</th>
                		<th><?php echo $data->discount_price; ?></th>
                	</tr>
                </table>
            </div>

			<?php if ( $market_type == 99 ){ ?>
	            <h2 style='margin-top:20px;'>订单状态</h2>
				<form action="order.php?act=edit" method="post" id="edit">
					<input type='hidden' name="ID" value='<?php echo $_GET['id'] ?>' />
					<div class="result-content" style="margin-bottom:20px;">
		                <table class="result-tab" width="100%">
		                	<tr>
		                		<th>支付状态:</th>
		                		<th>
		                			<select name="PayStatus" class="status">
			                			<?php foreach($arrPayStatus as $key=>$PayStatus){ ?>
			                				<?php $select = ($key == $data->pay_status) ? 'selected' : ''; ?>
			                				<option value="<?php echo $key ?>" <?php echo $select; ?> ><?php echo $PayStatus ?></option>
			                			<?php } ?>
		                			</select>
		                		</th>

		                		<th>订单状态:</th>
		                		<th>
		                			<select name="OrderStatus" class="status">
			                			<?php foreach($arrOrderStatus as $key=>$OrderStatus){ ?>
			                				<?php $select = ($key == $data->order_status) ? 'selected' : ''; ?>
			                				<option value="<?php echo $key ?>" <?php echo $select; ?> ><?php echo $OrderStatus ?></option>
			                			<?php } ?>
		                			</select>
		                		</th>
		                	</tr>
		                </table>
		            </div>
	            </form>
            <?php } ?>

         	<h2 style='margin-top:20px;'>订单详情</h2>
            <div class="result-content" style="margin-bottom:20px;">
                <table class="result-tab" width="100%">
                	<tr>
                		<th>商品图片</th>
                		<th>商品名称</th>
                		<th>货号</th>
                		<th>商品价格</th>
                		<th>数量</th>
                	</tr>

                    <tr>
                    	<td><?php echo $data->product_image == '' ? '' : "<img src='http://b2c.taozhuma.com/upfiles/product/small/{$data->product_image}' width='50' />" ; ?></td>
                    	<td><?php echo $data->product_name; ?></td>
                        <td><?php echo $data->product_model; ?></td>
                        <td><?php echo $data->create_date; ?></td>
                        <td><?php echo $data->all_price; ?></td>
                    </tr>
                </table>
            </div>


            <?php if ( $data->pay_status == 0 ) { ?>
					<h2 style='margin-top:20px;'>支付二维码 (共需支付 <?php echo $data->fact_price; ?> 元)</h2>
					<img src='<?php echo $site ?>qrcode_img/wxpay/<?php echo $data->id; ?>.png' />
			<?php } ?>

        </div>
    <!--/main-->
</div>


<script>
	$('.status').change(function(){
		$('#edit').submit();
	})

</script>

</body>
</html>

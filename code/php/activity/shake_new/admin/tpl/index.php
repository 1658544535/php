
    <!--/sidebar-->
    <div class="main-wrap">
    	<div class="crumb-wrap">
            <div class="crumb-list"><i class="icon-font">&#xe06b;</i><span>欢迎您，『 <?php echo $market_name; ?> 』</span></div>
        </div>
		 <div class="result-wrap">
            <div class="result-title">
                <h1>基本数据</h1>
            </div>
            <div class="result-content">
                <dl class="short-wrap">
                    <dd>分销商数 </br>( <?php echo $pur_num; ?> )</dd>
                   	<dd>成功交易订单</br>( <?php echo $success_order; ?> )</dd>
                    <dd>待付款订单</br>( <?php echo $paid_order; ?> )</dd>
                    <dd>总订单</br>( <?php echo $all_order; ?> )</dd>
                    <div class="short-wrap"></div>
                </dl>
            </div>
        </div>
    </div>
    <!--/main-->
</div>
</body>
</html>
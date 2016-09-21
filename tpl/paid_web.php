
<html>
<head>
    <meta http-equiv="content-type" content="text/html;charset=utf-8"/>
    <title>淘竹马</title>

	<script type="text/javascript">

		//调用微信JS api 支付
		(function(){
			callpay();
		})();

		function jsApiCall()
		{
			WeixinJSBridge.invoke(
				'getBrandWCPayRequest',
				<?php echo $jsApiParameters; ?>,
				function(res){
					WeixinJSBridge.log(res.err_msg);
					if(res.err_msg == "get_brand_wcpay_request:ok" ){
//						location.href='/orders?act=success';
						location.href='/wxpay/pay_result.php?out_trade_no=<?php echo $outTradeNo;?>';
					}else{
						location.href='/orders?sid=1';
					}
				}
			);
		}

		function callpay()
		{
			if (typeof WeixinJSBridge == "undefined"){
			    if( document.addEventListener ){
			        document.addEventListener('WeixinJSBridgeReady', jsApiCall, false);
			    }else if (document.attachEvent){
			        document.attachEvent('WeixinJSBridgeReady', jsApiCall);
			        document.attachEvent('onWeixinJSBridgeReady', jsApiCall);
			    }
			}else{
			    jsApiCall();
			}
		}


	</script>
</head>
<body>
	</br></br></br></br>

</body>
</html>
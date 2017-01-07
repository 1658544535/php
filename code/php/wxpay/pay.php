<?php
/**
 * 微信支付
 */
define('HN1', true);
require_once('../global.php');
define('CUR_DIR_PATH', dirname(__FILE__));

////防止支付后点击后退按钮，发起重复支付
//if(isset($_SESSION['payflag']) && $_SESSION['payflag']){
//	unset($_SESSION['payflag']);
//	redirect('/user_orders.php');
//}

$refUrl = '/pay_success.php?';
$prevUrl = getPrevUrl();

$isBuy = intval($_GET['buy']);
$orderId = intval($_GET['oid']);
$orderInfo = apiData('orderdetail.do', array('oid'=>$orderId));
!$orderInfo['success'] && redirect($prevUrl, $orderInfo['error_msg']);
$orderInfo = $orderInfo['result'];
$payWay = intval($_GET['payway']);

if(empty($isBuy)){//订单列表进来支付
    $result = apiData('payOrder.do', array('orderNo'=>$orderInfo['orderInfo']['orderNo'],'payMethod'=>$payWay,'uid'=>$userid,'pdkUid'=>$orderInfo['orderInfo']['pdkUid']));
	!$result['success'] && redirect($prevUrl, $result['error_msg']);
	$payParam = $result['result']['wxpay'];
	$refUrl .= 'url='.urlencode($prevUrl);
}else{//下单直接支付
	$payParam = array(
		'appId' => trim($_GET['appid']),
		'timeStamp' => trim($_GET['timestamp']),
		'nonceStr' => trim($_GET['noncestr']),
		'package' => trim($_GET['package']),
		'signType' => trim($_GET['signtype']),
		'paySign' => trim($_GET['sign']),
		'out_trade_no' => trim($_GET['outno']),
	);
}

//if(!empty($_SERVER['HTTP_REFERER'])){
//	$refInfo = pathinfo($_SERVER['HTTP_REFERER']);
//	if($refInfo['filename'] == 'order'){//下单后直接支付
//		$prevUrl = !$result['success'] ? '/user_orders.php' : 'pay_success.php?outno='.$payParam['out_trade_no'];
//	}else{
//		$prevUrl = $_SERVER['HTTP_REFERER'];
//	}
//}


//使用接口获取JS支付所需的数据
include_once('./lib/WxPay.Data.php');

$jsapi = new WxPayJsApiPay();
$jsapi->SetAppid($payParam['appId']);
$jsapi->SetTimeStamp($payParam['timeStamp']);
$jsapi->SetNonceStr($payParam['nonceStr']);
$jsapi->SetPackage($payParam['package']);
$jsapi->SetSignType($payParam['signType']);
$jsapi->SetPaySign($payParam['paySign']);
$jsApiParameters = json_encode($jsapi->GetValues());

?>
<!doctype html>
<html>
<head>
    <meta http-equiv="content-type" content="text/html;charset=utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1"/>
    <title><?php echo $site_name;?>-支付</title>
    <script type="text/javascript">
        //调用微信JS api 支付
        function jsApiCall()
        {
            WeixinJSBridge.invoke(
                'getBrandWCPayRequest',
                <?php echo $jsApiParameters; ?>,
                function(res){
                    switch(res.err_msg){
                        case "get_brand_wcpay_request:ok":
                            location.href = "<?php echo $refUrl;?>&state=1&outno=<?php echo $payParam['out_trade_no'];?>&oid=<?php echo $orderId;?>";
                            break;
                        case "get_brand_wcpay_request:cancel":
                        case "get_brand_wcpay_request:fail":
                            location.href = "<?php echo $refUrl;?>&state=0";
                            break;
                    }
                }
            );
        }

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
    </script>
</head>
<body>
</body>
</html>

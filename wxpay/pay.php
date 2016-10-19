<?php
/**
 * 微信支付
 */
define('HN1', true);
require_once('../global.php');
define('CUR_DIR_PATH', dirname(__FILE__));

$refUrl = '/pay_success.php?';
$prevUrl = getPrevUrl();

$orderId = intval($_GET['oid']);
if(empty($orderId)){//下单直接支付
	$payParam = array(
		'appId' => trim($_GET['appid']),
		'timeStamp' => trim($_GET['timestamp']),
		'nonceStr' => trim($_GET['noncestr']),
		'package' => trim($_GET['package']),
		'signType' => trim($_GET['signtype']),
		'paySign' => trim($_GET['sign']),
		'out_trade_no' => trim($_GET['outno']),
	);
}else{
	$orderInfo = apiData('orderdetail.do', array('oid'=>$orderId));
	!$orderInfo['success'] && redirect($prevUrl, $orderInfo['error_msg']);
	$orderInfo = $orderInfo['result'];
	$result = apiData('payOrder.do', array('orderNo'=>$orderInfo['orderInfo']['orderNo'],'payMethod'=>8,'uid'=>$userid));
	!$result['success'] && redirect($prevUrl, $result['error_msg']);
	$payParam = $result['result']['wxpay'];
	$refUrl .= 'url='.urlencode($prevUrl);
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





//$orderId = (isset($_GET['oid']) && !empty($_GET['oid'])) ? intval($_GET['oid']) : 0;
//empty($orderId) && redirect('/orders.php', '参数错误');
//
//
//include_once(MODEL_DIR.'/OrderModel.class.php');
//$Order = new OrderModel($db, 'orders');
//$order = $Order->get(array('order_id'=>$orderId));
//empty($order) && redirect('/orders.php', '订单不存在');
//($order->is_pay == 1) && redirect('/orders.php', '订单已支付');
//
////实付金额
//$total_pay = $order->pay_online-$order->discount_price-$order->discount_integral_price;
//
//$time = time();
//
//require_once "lib/WxPay.Api.php";
//require_once "pay_cls/WxPay.JsApiPay.php";
//require_once 'log.php';
//
//$logDir = LOG_DIR.'/wx/';
//!file_exists($logDir) && mkdir($logDir, 0777, true);
//$logFile = $logDir.'pay_'.date('Y-m-d', $time).'.log';
//
////初始化日志
//$logHandler= new CLogFileHandler($logFile);
////$log = Log::Init($logHandler, 15);
//
//$log = Log::Init($logHandler, 1);
//
//$log->DEBUG("应付金额为：" . $total_pay);
//
//
//
////①、获取用户openid
//$tools = new JsApiPay();
//$openId = $tools->GetOpenid();
//
////②、统一下单
//$input = new WxPayUnifiedOrder();
//$input->SetBody('产品购买');
//$input->SetOut_trade_no(genWXPayOutTradeNo());
//$input->SetTotal_fee(($total_pay)*100);
//$input->SetTime_start(date('YmdHis', $time));
//$input->SetNotify_url($gSetting['site_url'].$gSetting['wx_pay_dir'].'notify.php');
//$input->SetTrade_type("JSAPI");
//$input->SetOpenid($openId);
//$input->SetAttach($order->order_id.'|'.$order->order_number);
//$unifiedOrder = WxPayApi::unifiedOrder($input);
//$jsApiParameters = $tools->GetJsApiParameters($unifiedOrder);
//
//function genWXPayOutTradeNo(){
//    list($sec, $usec) = explode(" ", microtime());
//    $sec = $sec * 1000000;
//    return date('YmdHis', time()).intval($sec);
//}
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
                            location.href = "<?php echo $refUrl;?>&state=1&outno=<?php echo $payParam['out_trade_no'];?>";
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

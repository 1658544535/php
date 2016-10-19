<?php
define('HN1', true);
require_once('./global.php');

$orderType = $_SESSION['order']['type'];
$productId = $_SESSION['order']['productId'];
$grouponId = $_SESSION['order']['grouponId'];
$addressId = $_SESSION['order']['addressId'];
$attendId = $_SESSION['order']['attendId'];

//下单的类型
$ORDER_TYPES = array('free', 'groupon', 'join', 'alone', 'guess');
(!in_array($orderType, $ORDER_TYPES) || (($orderType != 'alone') && empty($grouponId))) && redirect('/', '非法下单');

$prevUrl = getPrevUrl();
//(empty($addressId) || empty($productId) || (($orderType != 'alone') && empty($grouponId))) && redirect($prevUrl, '参数错误');

//if(in_array($orderType, array('free'))){
//	$num = 1;
//}else{
//	$num = intval($_POST['num']);
//	empty($num) && redirect($prevUrl, '数量不能为0');
//}
$num = intval($_POST['num']);
$num = max(1, $num);

$cpnNo = trim($_POST['cpnno']);

$mapSource = array('groupon'=>1, 'free'=>2, 'guess'=>3, 'alone'=>4);
$source = ($orderType == 'join') ? ($_SESSION['order']['isfree'] ? 2 : 1) : $mapSource[$orderType];

$skuId = intval($_POST['skuid']);
$apiParam = array(
	'uid' => $userid,
	'pid' => $productId,
	'num' => $num,
	'consigneeType' => 1,
	'payMethod' => 8,
	'addressId' => $addressId,
	'buyer_message' => '',
	'couponNo' => '',
	'activityId' => ($orderType == 'alone') ? 0 : $grouponId,
	'source' => $source,
	'channel' => 2,
	'couponNo' => $cpnNo,
);
$skuId && $apiParam['skuLinkId'] = $skuId;

($orderType == 'join') && $apiParam['attendId'] = $attendId;
$result = apiData('addOrderByPurchase.do', $apiParam);
if(!$result['success']){
	$_SESSION['order_failure'] = true;
	redirect($prevUrl, $result['error_msg']);
}
$payInfo = $result['result']['wxpay'];

unset($_SESSION['order']);

$_SESSION['order_success'] = true;

if($result['result']['fullpay'] == 1){
	redirect('/user_orders.php', '下单成功');
}else{
	$url = '/wxpay/pay.php?appid='.$payInfo['appid'].'&timestamp='.$payInfo['timestamp'].'&noncestr='.$payInfo['noncestr'].'&prepayid='.$payInfo['prepayid'].'&outno='.$payInfo['out_trade_no'].'&sign='.$payInfo['sign'];
	redirect($url);
}
exit();


//使用接口获取JS支付所需的数据
$payParam = $result['result']['wxpay'];
include_once('./wxpay/lib/WxPay.Data.php');

$jsapi = new WxPayJsApiPay();
$jsapi->SetAppid($payParam['appid']);
$jsapi->SetTimeStamp($payParam['timestamp']);
$jsapi->SetNonceStr($payParam['noncestr']);
$jsapi->SetPackage('prepay_id='.$payParam['prepayid']);
$jsapi->SetSignType("MD5");
$jsapi->SetPaySign($jsapi->MakeSign());
$jsApiParameters = json_encode($jsapi->GetValues());


////php获取JS支付所需的数据(当不能使用以上方法支付时，使用此方法)
////调用支付
//$tools = new JsApiPay();
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
?>
<!doctype html>
<html>
<head>
    <meta http-equiv="content-type" content="text/html;charset=utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1"/>
    <title><?php echo $gSetting['site_name'];?>-支付</title>
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
                            window.location.href = "<?php echo $site;?>pay_success.php?no=<?php echo $payParam['out_trade_no'];?>";
                            break;
                        case "get_brand_wcpay_request:cancel":
                        case "get_brand_wcpay_request:fail":
                            window.location.href = "<?php echo $site;?>pay_failure.php";
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
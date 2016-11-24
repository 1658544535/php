<?php
define('HN1', true);
require_once('./global.php');

$orderType = $_SESSION['order']['type'];
$productId = $_SESSION['order']['productId'];
$grouponId = $_SESSION['order']['grouponId'];
$addressId = $_SESSION['order']['addressId'];
$attendId = $_SESSION['order']['attendId'];

//下单的类型
$ORDER_TYPES = array('free', 'groupon', 'join', 'alone', 'guess', 'raffle01', 'seckill', 'raffle');
(!in_array($orderType, $ORDER_TYPES) || (($orderType != 'alone') && empty($grouponId))) && redirect('/', '非法下单');

$prevUrl = getPrevUrl();

$num = intval($_POST['num']);
$num = max(1, $num);

$cpnNo = trim($_POST['cpnno']);
$buyer_message   = CheckDatas( 'buyer_message', '' );
$mapSource = array('groupon'=>1, 'free'=>2, 'guess'=>3, 'alone'=>4, 'raffle01'=>5, 'seckill'=>6, 'raffle'=>7);
$source = ($orderType == 'join') ? $_SESSION['order']['source'] : $mapSource[$orderType];

$skuId = intval($_POST['skuid']);
$apiParam = array(
	'uid' => $userid,
	'pid' => $productId,
	'num' => $num,
	'consigneeType' => 1,
	'payMethod' => 8,
	'addressId' => $addressId,
	'buyer_message' => $buyer_message,
	'activityId' => ($orderType == 'alone') ? 0 : $grouponId,
	'source' => $source,
	'channel' => 2,
	'couponNo' => $cpnNo,
    'ip' => GetIP(),
);
$apiParam['skuLinkId'] = $skuId;

($orderType == 'join') && $apiParam['attendId'] = $attendId;
$result = apiData('addOrderByPurchase.do', $apiParam);
if(!$result['success']){
	$_SESSION['order_failure'] = true;
// 	redirect($prevUrl, $result['error_msg']);
	redirect('index.php', $result['error_msg']);
}
$payInfo = $result['result']['wxpay'];

$_SESSION['order_success'] = true;

if(!$skuId){
	$time = time();
	$_logDir = LOG_INC.'groupon/join/';
	!file_exists($_logDir) && mkdir($_logDir, 0777, true);
	$_logFile = $_logDir.'nosku_'.date('Y-m-d', $time).'.txt';
	$_logInfo = "【".date('Y-m-d H:i:s', $time)."  订单ID:{$result['result']['orderId']}】\r\n下单类型:{$orderType}      来源:{$source}\r\n";
	$_logInfo .= "sku:".var_export($skuId)."\r\n";
	$_logInfo .= "临时购物车\r\n".var_export($_SESSION['order'], true)."\r\n";
	$_logInfo .= "调用接口提交的参数\r\n".var_export($apiParam, true)."\r\n";
	$_logInfo .= "User Agent：{$_SERVER['HTTP_USER_AGENT']}";
	$_logInfo .= "\r\n\r\n";
	file_put_contents($_logFile, $_logInfo, FILE_APPEND);
}

if($result['result']['fullpay'] == 1){
	$orderInfo = apiData('orderdetail.do', array('oid'=>$result['result']['orderId']));
	$_refreUrl = $orderInfo['result']['attendId'] ? '/groupon_join.php?aid='.$orderInfo['result']['attendId'] : '/user_orders.php';
	redirect($_refreUrl, '下单成功');
}else{
	$url = '/wxpay/pay.php?appid='.$payInfo['appId'].'&timestamp='.$payInfo['timeStamp'].'&noncestr='.$payInfo['nonceStr'].'&package='.$payInfo['package'].'&outno='.$payInfo['out_trade_no'].'&signtype='.$payInfo['signType'].'&sign='.$payInfo['paySign'].'&oid='.$result['result']['orderId'].'&buy=1';
	redirect($url);
}
exit();
?>

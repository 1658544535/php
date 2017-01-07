<?php
define('HN1', true);
require_once('./global.php');

$orderId = intval($_GET['oid']);
$orderInfo = apiData('orderdetail.do', array('oid'=>$orderId));
$orderInfo = $orderInfo['result'];
$payWay = intval($_GET['payway']);

if($payWay == 4){
	$orderpay = apiData('payOrder.do', array('orderNo'=>$orderInfo['orderInfo']['orderNo'],'payMethod'=>$payWay,'pdkUid'=>$orderInfo['orderInfo']['pdkUid'],'uid'=>$userid));
	$_refreUrl = 'order_detail.php?oid='.$orderInfo['orderInfo']['orderId'];
	if($orderpay['success'] !=''){
		redirect($_refreUrl,'支付成功');
	}else{
		redirect($_refreUrl,'支付失败');
	}
}else{
	$url = '/wxpay/pay.php?oid='.$orderInfo['orderInfo']['orderId'].'&payway='.$payWay.'&buy=1';
	redirect($url);
}
exit();
?>

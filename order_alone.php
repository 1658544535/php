<?php
//直购下单
define('HN1', true);
require_once('./global.php');

IS_USER_LOGIN();

define('ORDER_IN', true);

$prevUrl = getPrevUrl();

$productId = intval($_GET['pid']);
empty($productId) && redirect($prevUrl);

$num = intval($_GET['num']);
$num = max(1, $num);

$skuId = intval($_GET['skuid']);
empty($skuId) && $skuId = '';
$info = apiData('addPurchase.do', array('activityId'=>0,'num'=>$num,'pid'=>$productId,'skuLinkId'=>$skuId,'source'=>4,'uid'=>$userid));
if($info['success']){
	$info = $info['result'];
}else{
	redirect($prevUrl, $info['error_msg']);
}

$grouponId = intval($_GET['id']);

$_SESSION['order']['type'] = 'alone';

include_once('order_common.php');
?>
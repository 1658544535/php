<?php
//免团下单
define('HN1', true);
require_once('./global.php');

IS_USER_LOGIN();

define('ORDER_IN', true);

$prevUrl = getPrevUrl();

$grouponId = intval($_GET['id']);
empty($grouponId) && redirect($prevUrl);

$productId = intval($_GET['pid']);

$time = time();

$num = 1;

$skuId = intval($_GET['skuid']);
empty($skuId) && $skuId = '';
$info = apiData('addPurchase.do', array('activityId'=>$grouponId,'num'=>$num,'pid'=>$productId,'skuLinkId'=>$skuId,'source'=>2,'uid'=>$userid));
if($info['success']){
	$info = $info['result'];
}else{
	redirect($prevUrl, $info['error_msg']);
}


$_SESSION['order']['type'] = 'free';

$_SESSION['order']['grouponId'] = $grouponId;

include_once('order_common.php');
?>
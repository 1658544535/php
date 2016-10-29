<?php
//参团下单
define('HN1', true);
require_once('./global.php');

IS_USER_LOGIN();

define('ORDER_IN', true);

$prevUrl = getPrevUrl();

$grouponId = intval($_GET['id']);
empty($grouponId) && redirect($prevUrl);

$productId = intval($_GET['pid']);

$attendId = intval($_GET['aid']);//参团id

//防止下单后点击手机物理返回按钮
if(isset($_SESSION['order_success']) && $_SESSION['order_success']){
	unset($_SESSION['order_success']);
	redirect('groupon_join.php?aid='.$attendId);
}

$num = intval($_GET['num']);
$num = max(1, $num);

$isGrouponFree = intval($_GET['free']);

$skuId = intval($_GET['skuid']);
empty($skuId) && $skuId = $_SESSION['order']['sku'] ? $_SESSION['order']['sku'] : '';
$info = apiData('addPurchase.do', array('activityId'=>$grouponId,'attendId'=>$attendId,'num'=>$num,'skuLinkId'=>$skuId,'pid'=>$productId,'source'=>$isGrouponFree?2:1,'uid'=>$userid));
if($info['success']){
	$info = $info['result'];
}else{
	redirect($prevUrl, $info['error_msg']);
}

$_SESSION['order']['type'] = 'join';
$_SESSION['order']['grouponId'] = $grouponId;
$_SESSION['order']['attendId'] = $attendId;
$_SESSION['order']['isfree'] = $isGrouponFree ? 1 : 0;//参加的团的类型

include_once('order_common.php');
?>
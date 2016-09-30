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

$isGrouponFree = intval($_GET['free']);
$attendId = intval($_GET['aid']);//参团id
$info = apiData('addPurchase.do', array('activityId'=>$grouponId,'attendId'=>$attendId,'num'=>1,'pid'=>$productId,'source'=>$isGrouponFree?2:1,'uid'=>$userid));
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
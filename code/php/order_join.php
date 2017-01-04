<?php
//参团下单
define('HN1', true);
require_once('./global.php');

IS_USER_LOGIN();

define('ORDER_IN', true);

$prevUrl = getPrevUrl();

$referer = $_SERVER['HTTP_REFERER'];
if($referer){
	$_referInfo = pathinfo($referer);
	if($_referInfo['filename'] == 'order'){
		$prevUrl = $_SESSION['referUrl'] ? $_SESSION['referUrl'] : '/';
		$_orderFailure = true;
	}else{
		$_SESSION['referUrl'] = $prevUrl;
	}
}

$grouponId = intval($_GET['id']);
empty($grouponId) && redirect($prevUrl);

$pdkUid    = intval($_GET['pdkUid']);

$productId = intval($_GET['pid']);

$attendId = intval($_GET['aid']);//参团id

//防止下单后点击手机物理返回按钮
if(isset($_SESSION['order_success']) && $_SESSION['order_success']){
	unset($_SESSION['order_success']);
	if($pdkUid !=''){
		redirect('groupon_join.php?aid='.$attendId.'&pdkUid='.$pdkUid);
	}else{
		redirect('groupon_join.php?aid='.$attendId);
	}
}

$num = intval($_GET['num']);
$num = max(1, $num);

$isGrouponFree = intval($_GET['free']);

if(isset($_GET['as'])){
	$activeSource = intval($_GET['as']);
	$_SESSION['order']['source'] = $activeSource;
}else{
	$activeSource = $_SESSION['order']['source'] ? $_SESSION['order']['source'] : '';
}
$skuId = intval($_GET['skuid']);
empty($skuId) && $skuId = $_SESSION['order']['sku'] ? $_SESSION['order']['sku'] : '';
$info = apiData('addPurchase.do', array('activityId'=>$grouponId,'attendId'=>$attendId,'num'=>$num,'skuLinkId'=>$skuId,'pid'=>$productId,'source'=>$activeSource,'uid'=>$userid,'pdkUid'=>$pdkUid));
empty($info) && redirect($prevUrl, '网络异常，请稍候访问');
if($info['success']){
	$info = $info['result'];
}else{
	$_errMsg = $_orderFailure ? '' : $info['error_msg'];
	redirect($prevUrl, $_errMsg);
}



//获取钱包余额信息
$infowallet = apiData('userWelletBalance.do', array('uid'=>$userid));
$infowallet = $infowallet['result'];


$_SESSION['order']['type'] = 'join';
$_SESSION['order']['grouponId'] = $grouponId;
$_SESSION['order']['attendId'] = $attendId;
$_SESSION['order']['pdkUid'] = $pdkUid;
//$_SESSION['order']['isfree'] = $isGrouponFree ? 1 : 0;//参加的团的类型

include_once('order_common.php');
?>
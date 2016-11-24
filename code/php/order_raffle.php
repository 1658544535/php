<?php
//免费抽奖
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
$productId = intval($_GET['pid']);

//防止下单后点击手机物理返回按钮
if(isset($_SESSION['order_success']) && $_SESSION['order_success']){
	unset($_SESSION['order_success']);
	redirect('groupon.php?id='.$grouponId);
}

$num = intval($_GET['num']);
$num = max(1, $num);

$skuId = intval($_GET['skuid']);
empty($skuId) && $skuId = $_SESSION['order']['sku'] ? $_SESSION['order']['sku'] : '';
$info = apiData('addPurchase.do', array('activityId'=>$grouponId,'num'=>$num,'skuLinkId'=>$skuId,'pid'=>$productId,'source'=>7,'uid'=>$userid));
empty($info) && redirect($prevUrl, '网络异常，请稍候访问');
if($info['success']){
	$info = $info['result'];
}else{
	$_errMsg = $_orderFailure ? '' : $info['error_msg'];
	redirect($prevUrl, $_errMsg);
}

$_SESSION['order']['type'] = 'raffle';
$_SESSION['order']['grouponId'] = $grouponId;

include_once('order_common.php');
?>
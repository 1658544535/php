<?php
//免团下单
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
$pdkUid    = intval($_GET['pdkUid']);
$grouponId = intval($_GET['id']);
empty($grouponId) && redirect($prevUrl);

//防止下单后点击手机物理返回按钮
if(isset($_SESSION['order_success']) && $_SESSION['order_success']){
	unset($_SESSION['order_success']);
	if($pdkUid !=''){
		redirect('groupon.php?id='.$grouponId.'&pdkUid='.$pdkUid);
	}else{
		redirect('groupon.php?id='.$grouponId);
	}
	}

$productId = intval($_GET['pid']);
$time = time();

$num = intval($_GET['num']);;

$skuId = intval($_GET['skuid']);
$invCode =intval($_GET['code']);
empty($skuId) && $skuId = $_SESSION['order']['sku'] ? $_SESSION['order']['sku'] : '';
$info = apiData('addPurchase.do', array('activityId'=>$grouponId,'num'=>$num,'pid'=>$productId,'skuLinkId'=>$skuId,'source'=>8,'uid'=>$userid,'invCode'=>$invCode,'pdkUid'=>$pdkUid));
if($info['success']){
	$info = $info['result'];
}else{
	redirect($prevUrl, $info['error_msg']);
}


//获取钱包余额信息
$infowallet = apiData('userWelletBalance.do', array('uid'=>$userid));
$infowallet = $infowallet['result'];


$_SESSION['order']['type'] = 'pdk';

$_SESSION['order']['grouponId'] = $grouponId;

$_SESSION['order']['pdkUid'] = $pdkUid;
include_once('order_common.php');
?>
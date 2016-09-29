<?php
//免团下单
define('HN1', true);
require_once('./global.php');
define('ORDER_IN', true);

$prevUrl = getPrevUrl();

$grouponId = intval($_GET['id']);
empty($grouponId) && redirect($prevUrl);

$productId = intval($_GET['pid']);

$time = time();

////拼团活动信息
//$objGroupon = D('Groupon');
//$groupon = $objGroupon->getInfo($grouponId);
//empty($groupon) && redirect($prevUrl);
//($groupon['type'] != 2) && redirect($prevUrl, '参数错误');
//($groupon['status'] != 1) && redirect($prevUrl, '活动不存在');
//(($groupon['activity_status'] == 0) || (strtotime($groupon['begin_time']) > $time)) && redirect($prevUrl, '活动未开始');
//(($groupon['activity_status'] == 2) || (strtotime($groupon['end_time']) < $time)) && redirect($prevUrl, '活动已结束');
//
////是否有团免券
//$objGCpn = D('GrouponFreeCoupon');
//$gCpn = $objGCpn->getUserCoupon($userid, array('valid'=>true,'intime'=>true));
//empty($gCpn) && redirect($prevUrl, '没有有效团免券');
//$isLeader = true;


$info = apiData('addPurchase.do', array('activityId'=>$grouponId,'num'=>1,'pid'=>$productId,'skuLinkId'=>'','source'=>2,'uid'=>$userid));
if($info['success']){
	$info = $info['result'];
}else{
	redirect($prevUrl, $info['error_msg']);
}


$_SESSION['order']['type'] = 'free';

$_SESSION['order']['grouponId'] = $grouponId;

include_once('order_common.php');
?>
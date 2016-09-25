<?php
//免团下单
define('HN1', true);
require_once('./global.php');
define('ORDER_IN', true);

$prevUrl = getPrevUrl();

$grouponId = intval($_GET['id']);
empty($grouponId) && redirect($prevUrl);

$time = time();

//拼团活动信息
$objGroupon = D('Groupon');
$groupon = $objGroupon->getInfo($grouponId);
empty($groupon) && redirect($prevUrl);
($groupon['type'] != 2) && redirect($prevUrl, '参数错误');
($groupon['status'] != 1) && redirect($prevUrl, '活动不存在');
(($groupon['activity_status'] == 0) || (strtotime($groupon['begin_time']) > $time)) && redirect($prevUrl, '活动未开始');
(($groupon['activity_status'] == 2) || (strtotime($groupon['end_time']) < $time)) && redirect($prevUrl, '活动已结束');

//是否有团免券
$objGCpn = D('GrouponFreeCoupon');
$gCpn = $objGCpn->getUserCoupon($userid, array('valid'=>true,'intime'=>true));
empty($gCpn) && redirect($prevUrl, '没有有效团免券');
$isLeader = true;

$_SESSION['order']['type'] = 'free';
$factOrderPrice = 0;
$productId = $groupon['product_id'];

define('GROUPON_FREE', true);

include_once('order_common.php');
?>